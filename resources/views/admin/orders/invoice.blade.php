<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - #{{ $order->order_no }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-slate-100 font-sans text-slate-800 p-8">

    <div class="max-w-4xl mx-auto">
        <!-- Print Button -->
        <div class="mb-6 flex justify-end no-print">
            <button onclick="window.print()" class="px-6 py-2 bg-teal-600 text-white rounded-lg font-bold shadow hover:bg-teal-700 transition">
                <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Print Invoice
            </button>
        </div>

        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <!-- Header -->
            <div class="px-10 py-8 bg-slate-800 text-white flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold tracking-wider">INVOICE</h1>
                    <p class="text-slate-400 mt-1">#{{ $order->order_no }}</p>
                </div>
                <div class="text-right flex flex-col items-end">
                    @if(isset($siteSettings['site_logo']) && $siteSettings['site_logo'])
                        <img src="{{ asset('storage/' . $siteSettings['site_logo']) }}" class="h-12 w-auto object-contain mb-2 bg-white p-1 rounded" alt="Site Logo">
                    @endif
                    <h2 class="text-2xl font-bold text-teal-400">{{ isset($siteSettings['site_title']) && $siteSettings['site_title'] ? $siteSettings['site_title'] : 'Pharmacy POS' }}</h2>
                    <p class="text-sm text-slate-300 mt-1">123 Health Avenue, City</p>
                    <p class="text-sm text-slate-300">support@pharmacy.com</p>
                </div>
            </div>

            <div class="p-10">
                <!-- Info Section -->
                <div class="flex justify-between items-start mb-10">
                    <div>
                        <p class="text-sm text-slate-400 font-semibold uppercase mb-1">Invoice To:</p>
                        <h3 class="text-lg font-bold text-slate-800">{{ $order->customer->name ?? 'Guest Customer' }}</h3>
                        <p class="text-slate-600">{{ $order->customer->phone ?? 'N/A' }}</p>
                        @if($order->customer_address)
                            <p class="text-slate-600 w-64">{{ $order->customer_address->address_line }}</p>
                        @endif
                    </div>
                    <div class="text-right">
                        <div class="mb-2">
                            <p class="text-sm text-slate-400 font-semibold uppercase mb-1">Invoice Date:</p>
                            <p class="font-bold text-slate-800">{{ $order->created_at->format('d M, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-400 font-semibold uppercase mb-1">Payment Method:</p>
                            <p class="font-bold text-slate-800 capitalize">{{ $order->payment_method ?? 'Cash on Delivery' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <table class="w-full text-left mb-8">
                    <thead>
                        <tr class="border-y-2 border-slate-200">
                            <th class="py-4 text-slate-600 uppercase text-xs tracking-wider">Item Description</th>
                            <th class="py-4 text-center text-slate-600 uppercase text-xs tracking-wider">Quantity</th>
                            <th class="py-4 text-right text-slate-600 uppercase text-xs tracking-wider">Price</th>
                            <th class="py-4 text-right text-slate-600 uppercase text-xs tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($order->order_items as $item)
                        <tr>
                            <td class="py-4">
                                <p class="text-slate-800 font-semibold">{{ $item->product->name ?? 'Unknown Product' }}</p>
                                @if($item->product)
                                <div class="text-[10px] text-slate-500 mt-1 mb-1">
                                    @if($item->product->generic)
                                        <div class="text-teal-600 font-semibold">{{ $item->product->generic->name }}</div>
                                    @endif
                                    @if($item->product->manufacturer)
                                        <div>Manufacturer: {{ $item->product->manufacturer->company_name }}</div>
                                    @endif
                                </div>
                                <p class="text-[10px] text-slate-500 mt-1">
                                    <span class="mr-2">SKU: {{ $item->product->sku }}</span>
                                    @if($item->product->strength || $item->product->medicine_type)
                                        <span class="text-slate-400">({{ $item->product->medicine_type }} {{ $item->product->strength }})</span>
                                    @endif
                                </p>
                                @endif
                            </td>
                            <td class="py-4 text-center text-slate-600">{{ $item->quantity }}</td>
                            <td class="py-4 text-right text-slate-600">৳{{ number_format($item->unit_price, 2) }}</td>
                            <td class="py-4 text-right font-bold text-slate-800">৳{{ number_format($item->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Totals -->
                <div class="flex justify-end">
                    <div class="w-72">
                        <div class="flex justify-between py-2 text-slate-600">
                            <span>Subtotal</span>
                            <span class="font-semibold">৳{{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-2 text-slate-600 border-b border-slate-200">
                            <span>Delivery Charge</span>
                            <span class="font-semibold">৳{{ number_format($order->delivery_charge, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-4 text-xl">
                            <span class="font-bold text-slate-800">Total Amount</span>
                            <span class="font-bold text-teal-600">৳{{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div class="px-10 py-6 bg-slate-50 border-t border-slate-100 text-center">
                <p class="text-slate-500 font-semibold text-sm">Thank you for your business!</p>
                <p class="text-slate-400 text-xs mt-1">If you have any questions about this invoice, please contact our support team.</p>
            </div>
        </div>
    </div>

</body>
</html>
