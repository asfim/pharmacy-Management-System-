<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Batch;

echo "=== STOCK BALANCES BY BRANCH ===\n";
$b1Count = DB::table('stock_balances')->where('branch_id', 1)->count();
$b1Sum   = DB::table('stock_balances')->where('branch_id', 1)->sum('qty_on_hand');

$b2Count = DB::table('stock_balances')->where('branch_id', 2)->count();
$b2Sum   = DB::table('stock_balances')->where('branch_id', 2)->sum('qty_on_hand');

echo "Branch 1 (AMINA KHATUN): {$b1Count} records | Total Qty: {$b1Sum}\n";
echo "Branch 2 (Dhanmondi Branch): {$b2Count} records | Total Qty: {$b2Sum}\n";

// Let's test a search query like POS does
$product = Product::with('activeBatches')->first();
echo "\n=== TEST MEDICINE: {$product->name} (ID: {$product->id}) ===\n";
foreach ($product->activeBatches as $b) {
    $qtyB1 = DB::table('stock_balances')->where('branch_id', 1)->where('batch_id', $b->id)->value('qty_on_hand') ?? 0;
    $qtyB2 = DB::table('stock_balances')->where('branch_id', 2)->where('batch_id', $b->id)->value('qty_on_hand') ?? 0;
    echo "Batch No: {$b->batch_no} | Batch Qty Field: {$b->quantity} | Branch 1 Qty: {$qtyB1} | Branch 2 Qty: {$qtyB2}\n";
}
