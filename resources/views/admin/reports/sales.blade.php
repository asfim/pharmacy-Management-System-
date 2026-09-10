@extends('admin.layouts.app')
@php $header = 'Sales Report'; @endphp
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Sales Report</h2>
    <p class="text-sm text-slate-500">Filter and analyze sales by date range</p>
</div>

<!-- Filter -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 mb-6">
    <form method="GET" class="flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">From</label>
            <input type="date" name="from" value="{{ $from->format('Y-m-d') }}" class="px-3 py-2 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
        </div>
        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">To</label>
            <input type="date" name="to" value="{{ $to->format('Y-m-d') }}" class="px-3 py-2 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
        </div>
        <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-5 py-2 rounded-xl transition">Apply Filter</button>
        <a href="{{ route('admin.reports.sales') }}" class="border border-slate-300 text-slate-600 hover:bg-slate-50 text-sm font-semibold px-5 py-2 rounded-xl transition">Reset</a>
    </form>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
        <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Total Sales</p>
        <p class="text-2xl font-bold text-teal-600">৳{{ number_format($totalSales, 2) }}</p>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
        <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Total Discount</p>
        <p class="text-2xl font-bold text-red-500">৳{{ number_format($totalDiscount, 2) }}</p>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
        <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Total Due</p>
        <p class="text-2xl font-bold text-orange-500">৳{{ number_format($totalDue, 2) }}</p>
    </div>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4 text-left">Invoice</th>
                    <th class="px-5 py-4 text-left">Customer</th>
                    <th class="px-5 py-4 text-left">Date</th>
                    <th class="px-5 py-4 text-right">Subtotal</th>
                    <th class="px-5 py-4 text-right">Discount</th>
                    <th class="px-5 py-4 text-right">Total</th>
                    <th class="px-5 py-4 text-right">Paid</th>
                    <th class="px-5 py-4 text-right">Due</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50" id="sales_tbody">
                @include('admin.reports.partials.sales_rows')
            </tbody>
        </table>
    </div>
    @if($sales->hasMorePages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50 text-center" id="load_more_container">
        <button id="load_more_btn" data-url="{{ $sales->nextPageUrl() }}" class="bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 px-6 py-2 rounded-xl text-sm font-semibold transition shadow-sm">
            Load More
        </button>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loadMoreBtn = document.getElementById('load_more_btn');
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function() {
                const url = this.getAttribute('data-url');
                if (!url) return;
                
                const originalText = this.innerText;
                this.innerText = 'Loading...';
                this.disabled = true;

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('sales_tbody').insertAdjacentHTML('beforeend', html);
                    
                    // Parse the new pagination URL from the fetched data, or just check if it was passed via header/hidden element.
                    // Wait, since we are returning just the partial, we don't know the next URL directly.
                    // Let's increment the page parameter in the URL.
                    let currentUrl = new URL(url);
                    let page = parseInt(currentUrl.searchParams.get('page'));
                    currentUrl.searchParams.set('page', page + 1);
                    
                    // We can check if the response was empty or too small, but it's easier to check if we loaded less than 10 items.
                    // Since it's a bit tricky to get next URL without returning JSON, we'll assume it has more if html length is decent.
                    // Actually, a better way is to see if the returned HTML contains TRs. If it does, we update the button's URL.
                    if (html.trim() !== '') {
                        this.setAttribute('data-url', currentUrl.toString());
                        this.innerText = originalText;
                        this.disabled = false;
                    } else {
                        document.getElementById('load_more_container').remove();
                    }
                })
                .catch(err => {
                    console.error(err);
                    this.innerText = originalText;
                    this.disabled = false;
                });
            });
        }
    });
</script>
@endpush
