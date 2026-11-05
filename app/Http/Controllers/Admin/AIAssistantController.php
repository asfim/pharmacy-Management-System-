<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\OnlineOrder;
use App\Models\Product;
use App\Models\Sale;
use App\Services\PharmacyAIAssistantService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AIAssistantController extends Controller
{
    /**
     * Display the AI Assistant interactive interface.
     */
    public function index()
    {
        $today = Carbon::today();

        $stats = [
            'total_medicines' => Product::count(),
            'total_batches'   => Batch::count(),
            'expired_count'   => Batch::where('expiry_date', '<', $today)->where('quantity', '>', 0)->count(),
            'near_30_count'   => Batch::whereBetween('expiry_date', [$today, $today->copy()->addDays(30)])->where('quantity', '>', 0)->count(),
            'today_sales'     => Sale::whereDate('created_at', $today)->sum('total'),
            'pending_orders'  => OnlineOrder::where('status', 'pending')->count(),
        ];

        return view('admin.ai.index', compact('stats'));
    }

    /**
     * Handle user question and return real-time database-backed AI answer.
     */
    public function ask(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $result = PharmacyAIAssistantService::ask($validated['message']);

        return response()->json([
            'status'      => 'success',
            'reply'       => $result['reply'],
            'suggestions' => $result['suggestions'],
            'engine'      => $result['engine'] ?? 'PharmaSys Smart Database Engine',
        ]);
    }
}
