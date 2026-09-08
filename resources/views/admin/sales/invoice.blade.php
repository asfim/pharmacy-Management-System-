<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $sale->invoice_no }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { background: white; padding: 0; }
            .print\:hidden { display: none !important; }
            .shadow-sm { box-shadow: none !important; }
        }
    </style>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded shadow-sm">
        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">INVOICE</h1>
                <p class="text-slate-500 mt-1">#{{ $sale->invoice_no }}</p>
                <p class="text-slate-500">{{ $sale->created_at->format('d M Y, h:i A') }}</p>
            </div>
            <div class="text-right">
                <h2 class="text-xl font-bold text-slate-800">Pharmacy</h2>
                <p class="text-slate-500 text-sm">Address Line 1<br>City, Country<br>Phone: +880123456789</p>
            </div>
        </div>

        <div class="mb-8 border-b pb-8">
            <h3 class="text-slate-600 font-semibold mb-2">Billed To:</h3>
            @if($sale->customer)
                <p class="text-slate-800 font-medium">{{ $sale->customer->name }}</p>
                <p class="text-slate-500 text-sm">{{ $sale->customer->phone }}</p>
                <p class="text-slate-500 text-sm">{{ $sale->customer->address }}</p>
            @else
                <p class="text-slate-800">Walk-in Customer</p>
            @endif
        </div>

        <table class="w-full mb-8 text-left">
            <thead>
                <tr class="border-b text-slate-600">
                    <th class="py-2">Item</th>
                    <th class="py-2">Batch</th>
                    <th class="py-2 text-right">Price</th>
                    <th class="py-2 text-right">Qty</th>
                    <th class="py-2 text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->items as $item)
                <tr class="border-b text-slate-800">
                    <td class="py-3">{{ $item->product->name ?? 'Unknown' }}</td>
                    <td class="py-3 text-sm text-slate-500">{{ $item->batch->batch_no ?? '-' }}</td>
                    <td class="py-3 text-right">৳{{ number_format($item->price, 2) }}</td>
                    <td class="py-3 text-right">{{ $item->quantity }}</td>
                    <td class="py-3 text-right font-medium">৳{{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-end">
            <div class="w-64 space-y-2">
                <div class="flex justify-between text-slate-600">
                    <span>Subtotal:</span>
                    <span>৳{{ number_format($sale->subtotal, 2) }}</span>
                </div>
                @if($sale->discount > 0)
                <div class="flex justify-between text-slate-600">
                    <span>Discount:</span>
                    <span>-৳{{ number_format($sale->discount, 2) }}</span>
                </div>
                @endif
                @if($sale->tax > 0)
                <div class="flex justify-between text-slate-600">
                    <span>Tax:</span>
                    <span>৳{{ number_format($sale->tax, 2) }}</span>
                </div>
                @endif
                <div class="flex justify-between text-lg font-bold text-slate-800 pt-2 border-t">
                    <span>Total:</span>
                    <span>৳{{ number_format($sale->total, 2) }}</span>
                </div>
                <div class="flex justify-between text-slate-600 pt-2">
                    <span>Paid:</span>
                    <span class="text-green-600">৳{{ number_format($sale->paid, 2) }}</span>
                </div>
                <div class="flex justify-between text-slate-600">
                    <span>Due:</span>
                    <span class="{{ $sale->due > 0 ? 'text-red-600' : '' }}">৳{{ number_format($sale->due, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="mt-12 text-center text-slate-500 text-sm">
            <p>Thank you for your business!</p>
        </div>

        <div class="mt-8 flex justify-center print:hidden gap-4">
            <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700">
                <i class="fas fa-print"></i> Print Invoice
            </button>
            <a href="{{ route('admin.pos.index') }}" class="bg-gray-200 text-gray-800 px-6 py-2 rounded shadow hover:bg-gray-300">
                Back to POS
            </a>
        </div>
    </div>
</body>
</html>
