<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $sale->invoice_no }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        @media print {
            body { background: white; padding: 0; margin: 0; }
            .print\:hidden { display: none !important; }
            .shadow-2xl, .shadow-lg, .shadow-sm { box-shadow: none !important; }
            .bg-emerald-50 { background-color: #ecfdf5 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .bg-emerald-600 { background-color: #059669 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .text-emerald-600 { color: #059669 !important; }
            .bg-gray-50 { background-color: #f9fafb !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .border-emerald-100 { border-color: #d1fae5 !important; }
            .page-break { page-break-inside: avoid; }
        }
    </style>
</head>
<body class="bg-slate-100 py-10 antialiased text-slate-800">
    
    <!-- Action Buttons -->
    <div class="max-w-4xl mx-auto mb-6 flex justify-end gap-4 print:hidden">
        <a href="{{ route('admin.pos.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl font-medium hover:bg-slate-50 hover:text-slate-900 transition-all shadow-sm flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back to POS
        </a>
        <button onclick="window.print()" class="px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-xl font-medium hover:from-emerald-700 hover:to-teal-700 transition-all shadow-md shadow-emerald-500/20 flex items-center gap-2">
            <i class="fas fa-print"></i> Print Invoice
        </button>
    </div>

    <!-- Invoice Wrapper -->
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-2xl overflow-hidden print:shadow-none print:rounded-none relative">
        
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: radial-gradient(#059669 1px, transparent 1px); background-size: 32px 32px;"></div>

        <!-- Header Section -->
        <div class="relative bg-emerald-50/50 p-10 sm:p-14 border-b border-emerald-100/50">
            <div class="flex flex-col sm:flex-row justify-between items-start gap-8 relative z-10">
                <!-- Company Info -->
                <div>
                    @php
                        $siteLogo = \App\Models\Setting::where('key', 'site_logo')->value('value');
                        $siteTitle = \App\Models\Setting::where('key', 'site_title')->value('value') ?: 'PHARMA SYS';
                        $titleParts = explode(' ', $siteTitle, 2);
                        $firstPart = $titleParts[0];
                        $secondPart = isset($titleParts[1]) ? $titleParts[1] : '';
                    @endphp
                    <div class="flex items-center gap-3 mb-4">
                        @if($siteLogo)
                            <img src="{{ asset('storage/' . $siteLogo) }}" class="h-12 w-auto object-contain" alt="Site Logo">
                        @else
                            <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            </div>
                        @endif
                        <h1 class="text-3xl font-extrabold tracking-tight text-slate-800">
                            <span class="text-emerald-600">{{ $firstPart }}</span>{{ $secondPart ? ' ' . $secondPart : '' }}
                        </h1>
                    </div>
                    <div class="text-slate-500 text-sm space-y-1">
                        <p><i class="fas fa-map-marker-alt w-4 text-center mr-1 text-slate-400"></i> {{ \App\Models\Setting::where('key', 'footer_address')->value('value') ?? '123 Pharmacy Road, Dhaka' }}</p>
                        <p><i class="fas fa-phone-alt w-4 text-center mr-1 text-slate-400"></i> {{ \App\Models\Setting::where('key', 'footer_phone')->value('value') ?? '+880 1234 567890' }}</p>
                        <p><i class="fas fa-envelope w-4 text-center mr-1 text-slate-400"></i> {{ \App\Models\Setting::where('key', 'footer_email')->value('value') ?? 'support@pharmasys.com' }}</p>
                    </div>
                </div>

                <!-- Invoice Details -->
                <div class="text-left sm:text-right">
                    <h2 class="text-4xl font-black text-slate-200 tracking-wider mb-2">INVOICE</h2>
                    <div class="inline-block bg-white px-4 py-2 rounded-lg border border-slate-100 shadow-sm mb-4">
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-0.5">Invoice Number</p>
                        <p class="text-lg font-bold text-emerald-600">#{{ $sale->invoice_no }}</p>
                    </div>
                    <div class="text-sm text-slate-500 space-y-1">
                        <p><span class="font-semibold text-slate-700">Date Issued:</span> {{ $sale->created_at->format('d M, Y') }}</p>
                        <p><span class="font-semibold text-slate-700">Time:</span> {{ $sale->created_at->format('h:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer & Payment Info -->
        <div class="px-10 sm:px-14 py-10 grid grid-cols-1 md:grid-cols-2 gap-10">
            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Billed To</h3>
                @if($sale->customer)
                    <h4 class="text-xl font-bold text-slate-800 mb-1">{{ $sale->customer->name }}</h4>
                    <div class="text-slate-500 text-sm space-y-1">
                        @if($sale->customer->phone)
                            <p><i class="fas fa-phone-alt w-4 mr-1 text-slate-400"></i> {{ $sale->customer->phone }}</p>
                        @endif
                        @if($sale->customer->email)
                            <p><i class="fas fa-envelope w-4 mr-1 text-slate-400"></i> {{ $sale->customer->email }}</p>
                        @endif
                        @if($sale->customer->address)
                            <p><i class="fas fa-map-marker-alt w-4 mr-1 text-slate-400"></i> {{ $sale->customer->address }}</p>
                        @endif
                    </div>
                @else
                    <h4 class="text-xl font-bold text-slate-800">Walk-in Customer</h4>
                    <p class="text-slate-500 text-sm mt-1">Retail Sale</p>
                @endif
            </div>
            
            <div class="md:text-right">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Payment Info</h3>
                <div class="space-y-2 text-sm">
                    <p class="flex md:justify-end items-center gap-2">
                        <span class="text-slate-500">Total Amount:</span>
                        <span class="font-bold text-slate-800">৳{{ number_format($sale->total, 2) }}</span>
                    </p>
                    <p class="flex md:justify-end items-center gap-2">
                        <span class="text-slate-500">Paid Amount:</span>
                        <span class="font-bold text-emerald-600">৳{{ number_format($sale->paid, 2) }}</span>
                    </p>
                    @if($sale->due > 0)
                    <p class="flex md:justify-end items-center gap-2">
                        <span class="text-slate-500">Due Amount:</span>
                        <span class="font-bold text-rose-500 bg-rose-50 px-2 py-0.5 rounded">৳{{ number_format($sale->due, 2) }}</span>
                    </p>
                    <p class="text-xs text-rose-500 font-medium mt-1">Please pay the due amount at earliest convenience.</p>
                    @else
                    <p class="inline-block mt-1 px-3 py-1 bg-emerald-50 text-emerald-600 text-xs font-bold rounded-full uppercase tracking-wider border border-emerald-100">
                        <i class="fas fa-check-circle mr-1"></i> Paid in Full
                    </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="px-10 sm:px-14">
            <div class="rounded-xl overflow-hidden border border-slate-200">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="py-4 px-6 font-semibold text-slate-700">Item Description</th>
                            <th class="py-4 px-6 font-semibold text-slate-700">Batch</th>
                            <th class="py-4 px-6 font-semibold text-slate-700 text-right">Price</th>
                            <th class="py-4 px-6 font-semibold text-slate-700 text-center">Qty</th>
                            <th class="py-4 px-6 font-semibold text-slate-700 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($sale->items as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors page-break">
                            <td class="py-4 px-6">
                                <p class="font-medium text-slate-800">{{ $item->product->name ?? 'Unknown Product' }}</p>
                                @if($item->product && $item->product->generic_name)
                                    <p class="text-xs text-slate-500 mt-0.5">{{ $item->product->generic_name }}</p>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                    {{ $item->batch->batch_no ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right text-slate-600">৳{{ number_format($item->price, 2) }}</td>
                            <td class="py-4 px-6 text-center text-slate-800 font-medium">{{ $item->quantity }}</td>
                            <td class="py-4 px-6 text-right font-bold text-slate-800">৳{{ number_format($item->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Totals Section -->
        <div class="px-10 sm:px-14 py-10 flex flex-col md:flex-row justify-between items-end gap-10 border-b border-slate-100 page-break">
            <!-- Notes -->
            <div class="w-full md:w-1/2 text-sm text-slate-500">
                <h4 class="font-bold text-slate-700 mb-2">Terms & Conditions</h4>
                <ul class="list-disc pl-4 space-y-1">
                    <li>All sales are final. Medicines once sold cannot be returned or exchanged unless defective.</li>
                    <li>Please keep this invoice for your records and any future claims.</li>
                    <li>This is a computer generated invoice and does not require a signature.</li>
                </ul>
            </div>
            
            <!-- Summary -->
            <div class="w-full md:w-1/3 space-y-3 text-sm">
                <div class="flex justify-between items-center text-slate-600">
                    <span>Subtotal</span>
                    <span class="font-medium text-slate-800">৳{{ number_format($sale->subtotal, 2) }}</span>
                </div>
                @if($sale->discount > 0)
                <div class="flex justify-between items-center text-rose-500">
                    <span>Discount</span>
                    <span class="font-medium">- ৳{{ number_format($sale->discount, 2) }}</span>
                </div>
                @endif
                @if($sale->tax > 0)
                <div class="flex justify-between items-center text-slate-600">
                    <span>Tax (VAT)</span>
                    <span class="font-medium text-slate-800">৳{{ number_format($sale->tax, 2) }}</span>
                </div>
                @endif
                
                <div class="pt-4 border-t border-slate-200 mt-4 flex justify-between items-center">
                    <span class="text-base font-bold text-slate-800">Grand Total</span>
                    <span class="text-2xl font-black text-emerald-600">৳{{ number_format($sale->total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Footer Section -->
        <div class="bg-slate-50 p-8 text-center rounded-b-2xl print:rounded-none">
            <h4 class="text-lg font-bold text-slate-800 mb-2">Thank you for choosing PharmaSys!</h4>
            <p class="text-sm text-slate-500">Wishing you good health and a quick recovery.</p>
            <div class="mt-6 pt-6 border-t border-slate-200 text-xs text-slate-400 flex flex-col sm:flex-row justify-center gap-4">
                <span><i class="fas fa-globe mr-1"></i> www.pharmasys.com</span>
                <span class="hidden sm:inline">•</span>
                <span><i class="fas fa-envelope mr-1"></i> support@pharmasys.com</span>
                <span class="hidden sm:inline">•</span>
                <span><i class="fas fa-phone mr-1"></i> +880 1234 567890</span>
            </div>
        </div>

    </div>
</body>
</html>
