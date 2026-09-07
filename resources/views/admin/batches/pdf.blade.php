<!DOCTYPE html><html><head><meta charset="utf-8"><title>Batches</title>
<style>
body{font-family:DejaVu Sans,sans-serif;font-size:10px;color:#1e293b;}
h1{font-size:15px;margin-bottom:4px;}p{color:#64748b;margin:0 0 12px;}
table{width:100%;border-collapse:collapse;}
th{background:#f1f5f9;padding:7px 8px;text-align:left;font-size:9px;text-transform:uppercase;color:#475569;border-bottom:2px solid #e2e8f0;}
td{padding:6px 8px;border-bottom:1px solid #f1f5f9;}
tr:nth-child(even) td{background:#f8fafc;}
.expired{background:#fee2e2!important;color:#991b1b;font-weight:bold;}
.near{color:#c2410c;}
.badge{padding:2px 6px;border-radius:999px;font-size:8px;}
.badge-exp{background:#fee2e2;color:#991b1b;}
.badge-near{background:#ffedd5;color:#c2410c;}
</style></head><body>
<h1>Batch Records</h1>
<p>Exported {{ now()->format('d M Y, h:i A') }} &mdash; Total: {{ $batches->count() }}</p>
<table><thead><tr>
<th>#</th><th>Medicine</th><th>Batch No</th><th>Mfg Date</th><th>Expiry Date</th><th>Qty</th><th>Purchase Price</th><th>Sale Price</th>
</tr></thead><tbody>
@foreach($batches as $i => $b)
@php
$isExpired    = $b->expiry_date && \Carbon\Carbon::parse($b->expiry_date)->isPast();
$isNearExpiry = $b->expiry_date && \Carbon\Carbon::parse($b->expiry_date)->diffInDays(now()) <= 90 && !$isExpired;
@endphp
<tr class="{{ $isExpired ? 'expired' : '' }}">
    <td>{{ $i+1 }}</td>
    <td>{{ $b->product->name??'-' }}</td>
    <td>{{ $b->batch_no }}</td>
    <td>{{ $b->manufacturing_date ? \Carbon\Carbon::parse($b->manufacturing_date)->format('d M Y') : '-' }}</td>
    <td>
        {{ $b->expiry_date ? \Carbon\Carbon::parse($b->expiry_date)->format('d M Y') : '-' }}
        @if($isExpired) <span class="badge badge-exp">Expired</span>
        @elseif($isNearExpiry) <span class="badge badge-near">Near Expiry</span>
        @endif
    </td>
    <td>{{ number_format($b->quantity) }}</td>
    <td>{{ number_format($b->purchase_price,2) }}</td>
    <td>{{ number_format($b->sale_price,2) }}</td>
</tr>
@endforeach
</tbody></table></body></html>
