@extends('admin.layouts.app')
@php $header = 'Expiry Management'; @endphp
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Expiry Management</h2>
    <p class="text-sm text-slate-500">Track expired and near-expiry medicine batches</p>
</div>

<!-- Tabs -->
<div class="flex gap-1 mb-5 bg-slate-100 p-1 rounded-xl w-fit">
    <button onclick="showTab('expired')" id="tab-expired" class="tab-btn px-5 py-2 rounded-xl text-sm font-semibold transition bg-white text-red-700 shadow-sm">
        🔴 Expired ({{ $expired->total() }})
    </button>
    <button onclick="showTab('near')" id="tab-near" class="tab-btn px-5 py-2 rounded-xl text-sm font-semibold transition text-slate-600 hover:bg-white/60">
        🟡 Near Expiry ({{ $near90->total() }})
    </button>
</div>

<!-- Expired Tab -->
<div id="panel-expired">
    @if(!$expired->count())
    <div class="bg-green-50 border border-green-200 rounded-2xl p-8 text-center">
        <i class="fas fa-check-circle text-green-500 text-4xl mb-3 block"></i>
        <h3 class="font-semibold text-green-800">No Expired Medicines</h3>
    </div>
    @else
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-red-50 border-b border-red-200 text-xs text-red-600 uppercase">
                <tr>
                    <th class="px-5 py-4 text-left">Medicine</th>
                    <th class="px-5 py-4 text-left">Batch No</th>
                    <th class="px-5 py-4 text-left">Expiry Date</th>
                    <th class="px-5 py-4 text-right">Qty</th>
                    <th class="px-5 py-4 text-right">Stock Value</th>
                    <th class="px-5 py-4 text-center">Days Expired</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-red-50">
                @foreach($expired as $b)
                <tr class="hover:bg-red-50 transition">
                    <td class="px-5 py-3.5 font-semibold text-slate-800">{{ $b->product->name ?? '-' }}</td>
                    <td class="px-5 py-3.5 font-mono text-slate-600">{{ $b->batch_no }}</td>
                    <td class="px-5 py-3.5 text-red-600 font-semibold">{{ \Carbon\Carbon::parse($b->expiry_date)->format('d M Y') }}</td>
                    <td class="px-5 py-3.5 text-right font-bold text-red-700">{{ $b->quantity }}</td>
                    <td class="px-5 py-3.5 text-right text-slate-700">৳{{ number_format($b->quantity * $b->purchase_price, 2) }}</td>
                    <td class="px-5 py-3.5 text-center">
                        <span class="px-2.5 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">
                            {{ abs(\Carbon\Carbon::parse($b->expiry_date)->diffInDays(now())) }} days ago
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $expired->links() }}</div>
    </div>
    @endif
</div>

<!-- Near Expiry Tab -->
<div id="panel-near" class="hidden">
    @if(!$near90->count())
    <div class="bg-green-50 border border-green-200 rounded-2xl p-8 text-center">
        <i class="fas fa-check-circle text-green-500 text-4xl mb-3 block"></i>
        <h3 class="font-semibold text-green-800">No Near-Expiry Medicines in 90 Days</h3>
    </div>
    @else
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-yellow-50 border-b border-yellow-200 text-xs text-yellow-700 uppercase">
                <tr>
                    <th class="px-5 py-4 text-left">Medicine</th>
                    <th class="px-5 py-4 text-left">Batch No</th>
                    <th class="px-5 py-4 text-left">Expiry Date</th>
                    <th class="px-5 py-4 text-right">Qty</th>
                    <th class="px-5 py-4 text-right">Stock Value</th>
                    <th class="px-5 py-4 text-center">Days Left</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($near90 as $b)
                @php $daysLeft = now()->diffInDays(\Carbon\Carbon::parse($b->expiry_date)); @endphp
                <tr class="hover:bg-yellow-50 transition">
                    <td class="px-5 py-3.5 font-semibold text-slate-800">{{ $b->product->name ?? '-' }}</td>
                    <td class="px-5 py-3.5 font-mono text-slate-600">{{ $b->batch_no }}</td>
                    <td class="px-5 py-3.5 text-orange-600 font-semibold">{{ \Carbon\Carbon::parse($b->expiry_date)->format('d M Y') }}</td>
                    <td class="px-5 py-3.5 text-right font-bold text-slate-700">{{ $b->quantity }}</td>
                    <td class="px-5 py-3.5 text-right text-slate-700">৳{{ number_format($b->quantity * $b->purchase_price, 2) }}</td>
                    <td class="px-5 py-3.5 text-center">
                        <span class="px-2.5 py-1 {{ $daysLeft <= 30 ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700' }} rounded-full text-xs font-semibold">
                            {{ $daysLeft }} days
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $near90->links() }}</div>
    </div>
    @endif
</div>
@endsection
@push('scripts')
<script>
function showTab(name) {
    document.getElementById('panel-expired').classList.add('hidden');
    document.getElementById('panel-near').classList.add('hidden');
    document.getElementById('panel-' + name).classList.remove('hidden');
    document.querySelectorAll('.tab-btn').forEach(b => { b.classList.remove('bg-white','shadow-sm'); });
    document.getElementById('tab-' + name).classList.add('bg-white','shadow-sm');
}
</script>
@endpush
