<?php

namespace App\Services;

use App\Models\Batch;
use App\Models\Product;
use App\Models\Sale;
use App\Models\OnlineOrder;
use App\Models\Customer;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PharmacyAIAssistantService
{
    /**
     * Process an AI query using real-time database context and optional Google Gemini.
     *
     * @param string $userMessage
     * @return array ['reply' => string, 'suggestions' => array]
     */
    public static function ask(string $userMessage): array
    {
        $cleanMessage = trim($userMessage);
        $lowerMsg = strtolower($cleanMessage);

        // 1. Gather relevant database context based on detected intent
        $context = self::gatherDatabaseContext($lowerMsg, $cleanMessage);

        // 2. If Gemini API key is configured, use Google Gemini with database facts
        $geminiKey = config('services.gemini.key');
        if (!empty($geminiKey)) {
            $geminiReply = self::generateWithGemini($cleanMessage, $context, $geminiKey);
            if (!empty($geminiReply)) {
                return [
                    'reply'       => $geminiReply,
                    'suggestions' => self::getDynamicSuggestions($context['intent'] ?? 'general'),
                    'engine'      => 'Google Gemini AI (Live DB Integrated)',
                ];
            }
        }

        // 3. Fallback: Intelligent Deterministic Formatter
        $localReply = self::generateLocalReply($cleanMessage, $context);

        return [
            'reply'       => $localReply,
            'suggestions' => self::getDynamicSuggestions($context['intent'] ?? 'general'),
            'engine'      => 'PharmaSys Smart Database Engine',
        ];
    }

    /**
     * Gathers precise facts from the database for the user's inquiry.
     */
    protected static function gatherDatabaseContext(string $lowerMsg, string $originalMsg): array
    {
        $today = Carbon::today();
        $context = [
            'today_date' => $today->format('Y-m-d'),
            'intent'     => 'general',
            'data'       => [],
        ];

        $isExpiryQuery = (bool) preg_match('/(ex[apire]{3,6}|expiry|মেয়াদ)/i', $lowerMsg);
        $isFutureExpiry = (bool) preg_match('/(hobe|din|day|por|after|upcoming|next|beshi|হবে|দিন|পরে)/i', $lowerMsg);
        $isPastExpiry   = (bool) preg_match('/(hoise|geche|already|shesh|হয়েছে|গেছে|শেষ)/i', $lowerMsg);

        // --- Intent: Expiring in N Days / Soon ---
        if ($isExpiryQuery && ($isFutureExpiry || (!$isPastExpiry && preg_match('/\d+/', $lowerMsg)))) {
            $context['intent'] = 'near_expiry';

            // Extract number of days from message (default to 10 days if mentioned, else 30 days)
            $days = 30;
            if (preg_match('/(\d+)\s*(?:din|day|days|দিন)/i', $lowerMsg, $matches)) {
                $days = (int) $matches[1];
            } elseif (preg_match('/(\d+)/', $lowerMsg, $matches)) {
                $days = (int) $matches[1];
            }

            $context['target_days'] = $days;
            $targetDate = $today->copy()->addDays($days);

            $nearBatches = Batch::whereBetween('expiry_date', [$today, $targetDate])
                ->where('quantity', '>', 0)
                ->with(['product.generic'])
                ->orderBy('expiry_date', 'asc')
                ->limit(25)
                ->get();

            $context['total_near_count'] = Batch::whereBetween('expiry_date', [$today, $targetDate])->where('quantity', '>', 0)->count();
            $context['near_items'] = $nearBatches->map(function ($b) use ($today) {
                return [
                    'product_name'   => $b->product->name ?? 'Unknown',
                    'generic'        => $b->product->generic->name ?? 'N/A',
                    'batch_no'       => $b->batch_no,
                    'expiry_date'    => $b->expiry_date ? $b->expiry_date->format('Y-m-d') : 'N/A',
                    'days_remaining' => $b->expiry_date ? $today->diffInDays($b->expiry_date) : 0,
                    'stock_in_hand'  => $b->quantity,
                    'mrp'            => $b->product->mrp ?? $b->sale_price,
                ];
            })->toArray();

            // Also retrieve the single earliest expiry batch in the entire pharmacy for context
            $earliest = Batch::where('quantity', '>', 0)->where('expiry_date', '>=', $today)->orderBy('expiry_date', 'asc')->with('product')->first();
            if ($earliest) {
                $context['earliest_batch_overall'] = [
                    'product' => $earliest->product->name ?? 'Unknown',
                    'expiry'  => $earliest->expiry_date ? $earliest->expiry_date->format('Y-m-d') : 'N/A',
                    'days'    => $earliest->expiry_date ? $today->diffInDays($earliest->expiry_date) : 0,
                ];
            }

            return $context;
        }

        // --- Intent: Expired Medicines ---
        if ($isExpiryQuery) {
            $context['intent'] = 'expired_list';
            $expiredBatches = Batch::where('expiry_date', '<', $today)
                ->where('quantity', '>', 0)
                ->with(['product.generic'])
                ->orderBy('expiry_date', 'asc')
                ->limit(20)
                ->get();

            $context['total_expired_count'] = Batch::where('expiry_date', '<', $today)->where('quantity', '>', 0)->count();
            $context['expired_items'] = $expiredBatches->map(function ($b) use ($today) {
                return [
                    'product_name'  => $b->product->name ?? 'Unknown',
                    'generic'       => $b->product->generic->name ?? 'N/A',
                    'batch_no'      => $b->batch_no,
                    'expiry_date'   => $b->expiry_date ? $b->expiry_date->format('Y-m-d') : 'N/A',
                    'days_expired'  => $b->expiry_date ? $today->diffInDays($b->expiry_date) : 0,
                    'stock_in_hand' => $b->quantity,
                    'mrp'           => $b->product->mrp ?? $b->sale_price,
                ];
            })->toArray();

            return $context;
        }

        // --- Intent: Sales & Order Reports ---
        if (str_contains($lowerMsg, 'sale') || str_contains($lowerMsg, 'sales') || str_contains($lowerMsg, 'report') || str_contains($lowerMsg, 'বিক্রি') || str_contains($lowerMsg, 'অর্ডার') || str_contains($lowerMsg, 'revenue') || str_contains($lowerMsg, 'order')) {
            $context['intent'] = 'sales_report';

            $todaySalesCount = Sale::whereDate('created_at', $today)->count();
            $todaySalesTotal = Sale::whereDate('created_at', $today)->sum('total');

            $monthSalesTotal = Sale::whereMonth('created_at', $today->month)->whereYear('created_at', $today->year)->sum('total');
            $totalSalesAllTime = Sale::sum('total');

            $todayOrdersCount = OnlineOrder::whereDate('created_at', $today)->count();
            $pendingOrdersCount = OnlineOrder::where('status', 'pending')->count();
            $totalOnlineOrders = OnlineOrder::count();

            $context['sales_data'] = [
                'today_sales_count'   => $todaySalesCount,
                'today_sales_total'   => (float) $todaySalesTotal,
                'this_month_sales'    => (float) $monthSalesTotal,
                'all_time_sales'      => (float) $totalSalesAllTime,
                'today_orders_count'  => $todayOrdersCount,
                'pending_orders'      => $pendingOrdersCount,
                'total_online_orders' => $totalOnlineOrders,
            ];

            return $context;
        }

        // --- Intent: Low Stock / Reorder ---
        if (str_contains($lowerMsg, 'low stock') || str_contains($lowerMsg, 'kom stock') || str_contains($lowerMsg, 'কম স্টক') || str_contains($lowerMsg, 'stock out') || str_contains($lowerMsg, 'reorder')) {
            $context['intent'] = 'low_stock';

            // Find products where sum of batches <= min_stock
            $lowProducts = Product::where('status', 'active')
                ->with(['generic', 'batches'])
                ->get()
                ->filter(function ($p) {
                    $stock = $p->batches->sum('quantity');
                    return $stock <= ($p->min_stock ?: 10);
                })
                ->take(15);

            $context['low_stock_items'] = $lowProducts->map(function ($p) {
                return [
                    'name'          => $p->name,
                    'generic'       => $p->generic->name ?? 'N/A',
                    'current_stock' => $p->batches->sum('quantity'),
                    'min_stock'     => $p->min_stock ?: 10,
                    'mrp'           => $p->mrp ?: $p->sale_price,
                ];
            })->values()->toArray();

            return $context;
        }

        // --- Intent: Specific Medicine Availability / Price / Stock Check ---
        // Clean words like "ase kina", "stock", "koto", "medicine", "table", "is", "available"
        $stripped = preg_replace('/\b(medicine|medichine|ase|kina|koto|stock|available|price|dam|taka|er|ache|achey|do|we|have|is|in|check|bhai|ki|tai|tablets|tablet|syrup|capsule)\b/i', ' ', $lowerMsg);
        $possibleMedicineName = trim(preg_replace('/[^a-z0-9\s]/i', '', $stripped));

        if (!empty($possibleMedicineName) && strlen($possibleMedicineName) >= 3) {
            $tokens = array_values(array_filter(explode(' ', $possibleMedicineName), fn($w) => strlen($w) >= 3));
            $searchWord = !empty($tokens) ? $tokens[0] : $possibleMedicineName;

            $matchedProducts = Product::where('name', 'LIKE', "%{$searchWord}%")
                ->orWhereHas('generic', function ($q) use ($searchWord) {
                    $q->where('name', 'LIKE', "%{$searchWord}%");
                })
                ->with(['generic', 'manufacturer', 'batches'])
                ->limit(6)
                ->get();

            if ($matchedProducts->isNotEmpty()) {
                $context['intent'] = 'medicine_search';
                $context['search_term'] = $searchWord;
                $context['medicines'] = $matchedProducts->map(function ($p) use ($today) {
                    $totalStock = $p->batches->sum('quantity');
                    $activeBatches = $p->batches->filter(fn($b) => $b->quantity > 0)->map(function ($b) use ($today) {
                        return [
                            'batch_no'       => $b->batch_no,
                            'quantity'       => $b->quantity,
                            'expiry_date'    => $b->expiry_date ? $b->expiry_date->format('Y-m-d') : 'N/A',
                            'is_expired'     => $b->expiry_date && $b->expiry_date < $today,
                            'days_remaining' => $b->expiry_date && $b->expiry_date >= $today ? $today->diffInDays($b->expiry_date) : 0,
                        ];
                    })->values()->toArray();

                    return [
                        'id'                    => $p->id,
                        'name'                  => $p->name,
                        'generic'               => $p->generic->name ?? 'N/A',
                        'manufacturer'          => $p->manufacturer->name ?? 'N/A',
                        'strength'              => $p->strength ?? 'N/A',
                        'sale_price'            => (float) $p->sale_price,
                        'mrp'                   => (float) ($p->mrp ?: $p->sale_price),
                        'total_stock'           => $totalStock,
                        'in_stock'              => $totalStock > 0,
                        'prescription_required' => (bool) $p->prescription_required,
                        'batches'               => $activeBatches,
                    ];
                })->toArray();

                return $context;
            }
        }

        // --- Default: General Overview ---
        $context['intent'] = 'general';
        $context['overview'] = [
            'total_medicines'     => Product::count(),
            'total_batches'       => Batch::count(),
            'expired_batches'     => Batch::where('expiry_date', '<', $today)->where('quantity', '>', 0)->count(),
            'total_customers'     => Customer::count(),
            'total_suppliers'     => Supplier::count(),
            'total_online_orders' => OnlineOrder::count(),
            'total_sales'         => Sale::count(),
        ];

        return $context;
    }

    /**
     * Call Google Gemini API with real database context.
     */
    protected static function generateWithGemini(string $userMessage, array $context, string $apiKey): ?string
    {
        $model = config('services.gemini.model', 'gemini-1.5-flash');
        $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . urlencode($apiKey);

        $systemPrompt = "You are PharmaSys AI, an intelligent, professional pharmacy management AI assistant integrated into a modern Hospital & Pharmacy ERP.
You have direct, real-time access to the pharmacy database.
Answer the user's question clearly, concisely, and accurately based ONLY on the verified database context provided below.

Rules:
1. If the user asks in Bengali or Banglish, reply warmly and clearly in Bengali or Banglish (natural conversational tone).
2. If the user asks in English, reply in professional English.
3. Use clean GitHub markdown formatting with bullet points, bold highlights, and markdown tables where suitable.
4. Mention real numbers, exact medicine names, batch numbers, stock quantities, and expiry dates from the context.
5. If the database context shows 0 items (e.g. 0 expired medicines), explicitly mention that with reassurance.
6. Never make up medicines or stock that do not exist in the context.

--- LIVE DATABASE FACTS ---
" . json_encode($context, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "
--- END DATABASE FACTS ---";

        $payload = [
            'contents' => [
                [
                    'role'  => 'user',
                    'parts' => [
                        ['text' => $systemPrompt . "\n\nUser Question: " . $userMessage],
                    ],
                ],
            ],
            'generationConfig' => [
                'temperature' => 0.2,
            ],
        ];

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 25);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && !empty($response)) {
            $data = json_decode($response, true);
            $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
            if (!empty($text)) {
                return trim($text);
            }
        }

        Log::warning("Gemini AI Assistant response fallback (HTTP: {$httpCode})");
        return null;
    }

    /**
     * Fallback high-precision deterministic markdown generator.
     */
    protected static function generateLocalReply(string $userMessage, array $context): string
    {
        $intent = $context['intent'] ?? 'general';

        switch ($intent) {
            case 'expired_list':
                $total = $context['total_expired_count'] ?? 0;
                if ($total === 0) {
                    return "### ✅ কোনো মেয়াদোত্তীর্ণ ঔষধ নেই (No Expired Medicines)\n\n"
                        . "ডাটাবেজ অনুযায়ী এই মুহূর্তে আপনার ফার্মেসিতে **কোনো মেয়াদোত্তীর্ণ (Expired) ঔষধের ব্যাচ নেই**।\n"
                        . "- **সর্বমোট সক্রিয় ব্যাচ:** সব ব্যাচের মেয়াদ নিরাপদ সীমার মধ্যে আছে।\n"
                        . "- **স্ট্যাটাস:** আপনার ইনভেন্টরি সম্পূর্ণ সুরক্ষিত ও সেলস-রেডি!";
                }

                $reply = "### ⚠️ মেয়াদোত্তীর্ণ ঔষধের তালিকা (Expired Medicines List)\n\n"
                    . "আপনার ফার্মেসিতে বর্তমানে মোট **{$total} টি ব্যাচ** মেয়াদোত্তীর্ণ পাওয়া গেছে:\n\n"
                    . "| Medicine Name | Generic | Batch No | Expired Date | Stock | MRP |\n"
                    . "|:---|:---|:---|:---|:---|:---|\n";

                foreach ($context['expired_items'] as $item) {
                    $reply .= "| **{$item['product_name']}** | {$item['generic']} | `{$item['batch_no']}` | {$item['expiry_date']} ({$item['days_expired']} days ago) | **{$item['stock_in_hand']}** | ৳{$item['mrp']} |\n";
                }

                $reply .= "\n> 💡 **পরামর্শ:** নিরাপদ স্বাস্থ্যসেবার জন্য মেয়াদোত্তীর্ণ ব্যাচগুলো দ্রুত ড্যামেজ বা রিটার্ন সেকশনে স্থানান্তর করুন।";
                return $reply;

            case 'near_expiry':
                $days = $context['target_days'] ?? 30;
                $total = $context['total_near_count'] ?? 0;

                if ($total === 0) {
                    $earliestNote = '';
                    if (!empty($context['earliest_batch_overall'])) {
                        $e = $context['earliest_batch_overall'];
                        $earliestNote = "\n- **সবচেয়ে নিকটবর্তী ব্যাচের মেয়াদ:** **{$e['product']}** (তারিখ: {$e['expiry']}, অর্থাৎ আরও প্রায় **{$e['days']} দিন** বাকি)।";
                    }

                    return "### ⏳ আগামী {$days} দিনের মধ্যে মেয়াদ শেষ হওয়ার মতো ঔষধ নেই\n\n"
                        . "ডাটাবেজ চেক করে দেখা গেছে, **আগামী {$days} দিনের মধ্যে** ফার্মেসির কোনো ঔষধের মেয়াদ শেষ হচ্ছে না।{$earliestNote}\n\n"
                        . "আপনার স্টকের মেয়াদ এখনো নিরাপদ রয়েছে।";
                }

                $reply = "### ⏳ আগামী {$days} দিনে মেয়াদ শেষ হবে এমন ঔষধ ({$total} টি ব্যাচ)\n\n"
                    . "| Medicine Name | Generic | Batch No | Expiry Date | Days Left | Stock |\n"
                    . "|:---|:---|:---|:---|:---|:---|\n";

                foreach ($context['near_items'] as $item) {
                    $reply .= "| **{$item['product_name']}** | {$item['generic']} | `{$item['batch_no']}` | {$item['expiry_date']} | **{$item['days_remaining']} দিন** | {$item['stock_in_hand']} pcs |\n";
                }

                $reply .= "\n> 💡 **টিপস:** যেসব ঔষধের মেয়াদ দ্রুত শেষ হচ্ছে, সেগুলো আগে বিক্রি (FIFO) অথবা ডিসকাউন্ট অফারে দেওয়ার ব্যবস্থা করতে পারেন।";
                return $reply;

            case 'medicine_search':
                $meds = $context['medicines'] ?? [];
                if (empty($meds)) {
                    return "দুঃখিত, '{$context['search_term']}' নামে কোনো ঔষধ ডাটাবেজে পাওয়া যায়নি। বানানটি যাচাই করে আবার সার্চ করুন।";
                }

                $reply = "### 💊 ঔষধ অনুসন্ধান ফলাফল ('{$context['search_term']}')\n\n";
                foreach ($meds as $m) {
                    $stockBadge = $m['in_stock'] ? "🟢 **In Stock ({$m['total_stock']} units)**" : "🔴 **Out of Stock (0 units)**";
                    $rxBadge = $m['prescription_required'] ? "⚠️ Prescription Required" : "OTC (Over-The-Counter)";

                    $reply .= "#### {$m['name']} ({$m['strength']})\n"
                        . "- **Generic:** {$m['generic']}\n"
                        . "- **Manufacturer:** {$m['manufacturer']}\n"
                        . "- **MRP:** ৳{$m['mrp']} (Sale Price: ৳{$m['sale_price']})\n"
                        . "- **Stock Availability:** {$stockBadge} | {$rxBadge}\n";

                    if (!empty($m['batches'])) {
                        $reply .= "- **Active Batches:**\n";
                        foreach ($m['batches'] as $b) {
                            $expText = $b['is_expired'] ? "❌ Expired ({$b['expiry_date']})" : "✅ Exp: {$b['expiry_date']} ({$b['days_remaining']} days left)";
                            $reply .= "  - Batch `{$b['batch_no']}`: **{$b['quantity']} pcs** | {$expText}\n";
                        }
                    } else {
                        $reply .= "- **Batches:** কোনো সক্রিয় ব্যাচ অবশিষ্ট নেই।\n";
                    }
                    $reply .= "\n---\n";
                }
                return $reply;

            case 'sales_report':
                $d = $context['sales_data'] ?? [];
                return "### 📊 ফার্মেসি সেলস ও অর্ডার রিপোর্ট\n\n"
                    . "- **আজকের মোট বিক্রি (POS):** ৳" . number_format($d['today_sales_total'] ?? 0, 2) . " ({$d['today_sales_count']} টি ইনভয়েস)\n"
                    . "- **চলতি মাসের মোট বিক্রি:** ৳" . number_format($d['this_month_sales'] ?? 0, 2) . "\n"
                    . "- **সর্বমোট আজীবন বিক্রি:** ৳" . number_format($d['all_time_sales'] ?? 0, 2) . "\n\n"
                    . "#### 🛒 অনলাইন ই-কমার্স অর্ডার:\n"
                    . "- **আজকের নতুন অর্ডার:** {$d['today_orders_count']} টি\n"
                    . "- **পেন্ডিং অর্ডার (যাচাই প্রয়োজন):** **{$d['pending_orders']} টি**\n"
                    . "- **মোট অনলাইন অর্ডার:** {$d['total_online_orders']} টি";

            case 'low_stock':
                $items = $context['low_stock_items'] ?? [];
                if (empty($items)) {
                    return "### ✅ কোনো লো-স্টক ঔষধ নেই\n\nডাটাবেজ অনুযায়ী কোনো ঔষধের স্টক রিরিডার বা মিনিমাম স্টকের নিচে নেই।";
                }

                $reply = "### ⚠️ লো-স্টক ঔষধের তালিকা (Reorder Alert)\n\n"
                    . "| Medicine Name | Generic | Current Stock | Min Level | MRP |\n"
                    . "|:---|:---|:---|:---|:---|\n";

                foreach ($items as $item) {
                    $reply .= "| **{$item['name']}** | {$item['generic']} | **{$item['current_stock']} pcs** | {$item['min_stock']} pcs | ৳{$item['mrp']} |\n";
                }
                return $reply;

            default:
                $o = $context['overview'] ?? [];
                return "### 🤖 PharmaSys AI Assistant-এ স্বাগতম!\n\n"
                    . "আমি সরাসরি ফার্মেসির ডাটাবেজ থেকে রিয়েল-টাইম তথ্য সংগ্রহ করে উত্তর দিতে প্রস্তুত।\n\n"
                    . "#### 🏥 বর্তমান ফার্মেসি পরিসংখ্যান:\n"
                    . "- **মোট রেজিস্টার্ড মেডিসিন:** " . number_format($o['total_medicines'] ?? 0) . " টি\n"
                    . "- **মোট ইনভেন্টরি ব্যাচ:** " . number_format($o['total_batches'] ?? 0) . " টি\n"
                    . "- **মেয়াদোত্তীর্ণ ব্যাচ:** " . ($o['expired_batches'] ?? 0) . " টি\n"
                    . "- **মোট কাস্টমার:** " . number_format($o['total_customers'] ?? 0) . " জন\n"
                    . "- **মোট সরবরাহকারী (Suppliers):** " . ($o['total_suppliers'] ?? 0) . " টি\n\n"
                    . "#### আপনি নিচের প্রশ্নগুলো জিজ্ঞেস করতে পারেন:\n"
                    . "- *\"কি কি medicine expire hoise?\"*\n"
                    . "- *\"10 din ba tar beshi por kon kon medicine expire hobe?\"*\n"
                    . "- *\"Acedol medicine ta ase kina?\"*\n"
                    . "- *\"Ajker sales report koto?\"*\n"
                    . "- *\"Low stock medicine gulo ki ki?\"*";
        }
    }

    /**
     * Contextual suggested question chips.
     */
    protected static function getDynamicSuggestions(string $intent): array
    {
        switch ($intent) {
            case 'expired_list':
                return [
                    '10 din por kon medicine expire hobe?',
                    'Acedol medicine ta ase kina?',
                    'Ajker sales report dao',
                ];
            case 'near_expiry':
                return [
                    'Ki ki medicine expire hoise?',
                    'Low stock medicine gulo ki ki?',
                    'Acedol er stock koto?',
                ];
            case 'medicine_search':
                return [
                    'Napa medicine ase kina?',
                    'Ki ki medicine expire hoise?',
                    'Ajker sales report koto?',
                ];
            case 'sales_report':
                return [
                    'Ki ki medicine expire hoise?',
                    'Low stock medicine list',
                    'Acedol medicine ta ase kina?',
                ];
            default:
                return [
                    'Ki ki medicine expire hoise?',
                    '10 din por kon medicine expire hobe?',
                    'Acedol medicine ta ase kina?',
                    'Ajker sales report koto?',
                ];
        }
    }
}
