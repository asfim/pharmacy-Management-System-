<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Product;
use App\Models\StockBalance;
use App\Models\StockTransfer;
use App\Models\StockTransferItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockTransferController extends Controller
{
    public function index()
    {
        $transfers = StockTransfer::with(['sourceBranch', 'destinationBranch', 'items.product', 'items.batch'])
            ->latest()
            ->paginate(15);

        return view('admin.stock.transfers', compact('transfers'));
    }

    public function create()
    {
        $branches = Branch::where('status', 'active')->get();

        if ($branches->isEmpty()) {
            $branches = Branch::all();
        }

        // Determine default source branch
        $user = Auth::user();
        $defaultSourceBranchId = null;

        if ($user && $user->employee && $user->employee->branch_id) {
            $defaultSourceBranchId = $user->employee->branch_id;
        } else {
            $selectedBranchId = session('selected_branch_id');
            if ($selectedBranchId && $selectedBranchId !== 'all') {
                $defaultSourceBranchId = (int)$selectedBranchId;
            } else {
                $defaultSourceBranchId = $branches->first()?->id;
            }
        }

        return view('admin.stock.create_transfer', compact('branches', 'defaultSourceBranchId'));
    }

    public function getBranchProducts(Request $request)
    {
        $branchId = $request->input('branch_id');
        $query = trim($request->input('q', ''));
        $stats = $request->input('stats');

        if (!$branchId) {
            return response()->json($stats ? ['total_products' => 0] : []);
        }

        // Return total distinct products in stock for source branch stats badge
        if ($stats) {
            $totalCount = StockBalance::withoutGlobalScopes()
                ->where('branch_id', $branchId)
                ->where('qty_on_hand', '>', 0)
                ->distinct('product_id')
                ->count('product_id');

            return response()->json(['total_products' => $totalCount]);
        }

        // Fetch positive stock balances for the specified branch with eager-loaded product metadata
        $balanceQuery = StockBalance::withoutGlobalScopes()
            ->with(['product.generic', 'product.category', 'product.unit', 'batch'])
            ->where('branch_id', $branchId)
            ->where('qty_on_hand', '>', 0);

        if (!empty($query)) {
            $balanceQuery->whereHas('product', function ($qBuilder) use ($query) {
                $qBuilder->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('sku', 'LIKE', "%{$query}%")
                    ->orWhere('barcode', 'LIKE', "%{$query}%")
                    ->orWhere('strength', 'LIKE', "%{$query}%")
                    ->orWhere('dosage_form', 'LIKE', "%{$query}%")
                    ->orWhereHas('generic', function ($gQuery) use ($query) {
                        $gQuery->where('name', 'LIKE', "%{$query}%");
                    });
            });
        }

        // Fetch top matching stock balance rows (limit to prevent high memory payload)
        $balances = $balanceQuery->take(120)->get();

        $productsMap = [];

        foreach ($balances as $balance) {
            if (!$balance->product) {
                continue;
            }

            $p = $balance->product;
            $pId = $p->id;

            if (!isset($productsMap[$pId])) {
                if (count($productsMap) >= 30) {
                    continue;
                }

                $productsMap[$pId] = [
                    'id' => $p->id,
                    'name' => $p->name,
                    'sku' => $p->sku,
                    'barcode' => $p->barcode,
                    'generic_name' => $p->generic?->name,
                    'strength' => $p->strength,
                    'dosage_form' => $p->dosage_form,
                    'category_name' => $p->category?->name,
                    'unit' => is_object($p->unit) ? ($p->unit->name ?? 'Pcs') : ($p->unit ?? 'Pcs'),
                    'batches' => []
                ];
            }

            $productsMap[$pId]['batches'][] = [
                'batch_id' => $balance->batch_id,
                'batch_no' => $balance->batch?->batch_no ?? 'N/A',
                'expiry_date' => $balance->batch?->expiry_date ? $balance->batch->expiry_date->format('Y-m-d') : 'N/A',
                'qty_on_hand' => (int)$balance->qty_on_hand
            ];
        }

        return response()->json(array_values($productsMap));
    }

    public function store(Request $request)
    {
        $request->validate([
            'source_branch_id' => 'required|exists:branches,id',
            'destination_branch_id' => 'required|exists:branches,id|different:source_branch_id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.batch_id' => 'required|exists:batches,id',
            'items.*.quantity' => 'required|integer|min:1',
        ], [
            'destination_branch_id.different' => 'Source branch and destination branch must be different.',
            'items.required' => 'At least one medicine must be added for transfer.',
        ]);

        $sourceBranchId = (int)$request->source_branch_id;
        $destinationBranchId = (int)$request->destination_branch_id;
        $itemsData = $request->items;

        DB::transaction(function () use ($sourceBranchId, $destinationBranchId, $itemsData) {
            // Verify stock availability
            foreach ($itemsData as $index => $item) {
                $productId = (int)$item['product_id'];
                $batchId = (int)$item['batch_id'];
                $qty = (int)$item['quantity'];

                $balance = StockBalance::withoutGlobalScopes()
                    ->where('branch_id', $sourceBranchId)
                    ->where('product_id', $productId)
                    ->where('batch_id', $batchId)
                    ->first();

                $available = $balance ? $balance->qty_on_hand : 0;

                if ($qty > $available) {
                    $product = Product::find($productId);
                    $productName = $product ? $product->name : 'Item';
                    throw ValidationException::withMessages([
                        "items.{$index}.quantity" => "Requested transfer quantity ({$qty}) exceeds available stock ({$available}) for {$productName} at the source branch."
                    ]);
                }
            }

            // Generate Transfer No
            $nextId = (StockTransfer::withoutGlobalScopes()->max('id') ?? 0) + 1;
            $transferNo = 'TRF-' . date('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

            // Create Stock Transfer
            $transfer = StockTransfer::withoutGlobalScopes()->create([
                'source_branch_id' => $sourceBranchId,
                'destination_branch_id' => $destinationBranchId,
                'transfer_no' => $transferNo,
                'status' => 'completed',
                'shipped_at' => now(),
                'received_at' => now(),
            ]);

            // Deduct from Source & Add to Destination
            foreach ($itemsData as $item) {
                $productId = (int)$item['product_id'];
                $batchId = (int)$item['batch_id'];
                $qty = (int)$item['quantity'];

                // Create Transfer Item Record
                StockTransferItem::create([
                    'transfer_id' => $transfer->id,
                    'product_id' => $productId,
                    'batch_id' => $batchId,
                    'quantity' => $qty,
                    'received_quantity' => $qty,
                ]);

                // Deduct from Source Branch
                StockBalance::withoutGlobalScopes()
                    ->where('branch_id', $sourceBranchId)
                    ->where('product_id', $productId)
                    ->where('batch_id', $batchId)
                    ->decrement('qty_on_hand', $qty);

                // Add to Destination Branch
                $destBalance = StockBalance::withoutGlobalScopes()
                    ->where('branch_id', $destinationBranchId)
                    ->where('product_id', $productId)
                    ->where('batch_id', $batchId)
                    ->first();

                if ($destBalance) {
                    $destBalance->increment('qty_on_hand', $qty);
                } else {
                    StockBalance::withoutGlobalScopes()->create([
                        'branch_id' => $destinationBranchId,
                        'product_id' => $productId,
                        'batch_id' => $batchId,
                        'qty_on_hand' => $qty,
                        'reserved_qty' => 0,
                        'damaged_qty' => 0
                    ]);
                }
            }
        });

        return redirect()->route('admin.stock-transfers.index')->with('success', 'Stock transfer created and completed successfully.');
    }

    public function show($id)
    {
        $transfer = StockTransfer::withoutGlobalScopes()
            ->with(['sourceBranch', 'destinationBranch', 'items.product', 'items.batch'])
            ->findOrFail($id);

        return view('admin.stock.show_transfer', compact('transfer'));
    }

    public function approve(StockTransfer $transfer)
    {
        if ($transfer->status === 'completed') {
            return redirect()->back()->with('info', 'Transfer is already completed.');
        }

        DB::transaction(function () use ($transfer) {
            foreach ($transfer->items as $item) {
                // Deduct source
                StockBalance::withoutGlobalScopes()
                    ->where('branch_id', $transfer->source_branch_id)
                    ->where('product_id', $item->product_id)
                    ->where('batch_id', $item->batch_id)
                    ->decrement('qty_on_hand', $item->quantity);

                // Increment destination
                $destBalance = StockBalance::withoutGlobalScopes()
                    ->where('branch_id', $transfer->destination_branch_id)
                    ->where('product_id', $item->product_id)
                    ->where('batch_id', $item->batch_id)
                    ->first();

                if ($destBalance) {
                    $destBalance->increment('qty_on_hand', $item->quantity);
                } else {
                    StockBalance::withoutGlobalScopes()->create([
                        'branch_id' => $transfer->destination_branch_id,
                        'product_id' => $item->product_id,
                        'batch_id' => $item->batch_id,
                        'qty_on_hand' => $item->quantity,
                        'reserved_qty' => 0,
                        'damaged_qty' => 0
                    ]);
                }
            }

            $transfer->update([
                'status' => 'completed',
                'received_at' => now(),
            ]);
        });

        return redirect()->back()->with('success', 'Transfer approved and stock updated successfully.');
    }
}
