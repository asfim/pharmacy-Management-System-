@extends('admin.layouts.app')
@php $header = 'Expiry Report'; @endphp
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Expiry Report</h2>
    <p class="text-sm text-slate-500">Batches expiring within selected timeframe</p>
</div>

<!-- Filter -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 mb-6">
    <form method="GET" class="flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">Timeframe</label>
            <select name="days" class="px-4 py-2.5 border border-slate-300 rounded-xl text-sm w-48">
                <option value="30" {{ $days == 30 ? 'selected' : '' }}>Next 30 Days</option>
                <option value="60" {{ $days == 60 ? 'selected' : '' }}>Next 60 Days</option>
                <option value="90" {{ $days == 90 ? 'selected' : '' }}>Next 90 Days</option>
                <option value="180" {{ $days == 180 ? 'selected' : '' }}>Next 6 Months</option>
            </select>
        </div>
        <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">Apply</button>
    </form>
</div>

<div class="bg-orange-50 border border-orange-200 rounded-2xl p-4 mb-5 flex items-center gap-3">
    <i class="fas fa-exclamation-triangle text-orange-600 text-xl"></i>
    <p class="text-orange-800 font-medium text-sm">Total value at risk: <span class="font-bold text-lg">৳{{ number_format($totalValue, 2) }}</span></p>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4 text-left">Medicine</th>
                    <th class="px-5 py-4 text-left">Batch No</th>
                    <th class="px-5 py-4 text-left">Expiry Date</th>
                    <th class="px-5 py-4 text-right">Quantity Left</th>
                    <th class="px-5 py-4 text-right">Value (Buy Price)</th>
                    <th class="px-5 py-4 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50" id="expiry_tbody">
                @include('admin.reports.partials.expiry_rows')
            </tbody>
        </table>
    </div>
    @if($batches->hasMorePages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50 text-center" id="load_more_container">
        <button id="load_more_btn" data-url="{{ $batches->nextPageUrl() }}" class="bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 px-6 py-2 rounded-xl text-sm font-semibold transition shadow-sm">
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
                    document.getElementById('expiry_tbody').insertAdjacentHTML('beforeend', html);
                    
                    let currentUrl = new URL(url);
                    let page = parseInt(currentUrl.searchParams.get('page'));
                    currentUrl.searchParams.set('page', page + 1);
                    
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
