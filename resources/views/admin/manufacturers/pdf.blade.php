<!DOCTYPE html><html><head><meta charset="utf-8"><title>Manufacturers</title>
<style>
body{font-family:DejaVu Sans,sans-serif;font-size:10px;color:#1e293b;}
h1{font-size:15px;margin-bottom:4px;}p{color:#64748b;margin:0 0 12px;}
table{width:100%;border-collapse:collapse;}
th{background:#f1f5f9;padding:7px 8px;text-align:left;font-size:9px;text-transform:uppercase;color:#475569;border-bottom:2px solid #e2e8f0;}
td{padding:6px 8px;border-bottom:1px solid #f1f5f9;}
tr:nth-child(even) td{background:#f8fafc;}
.badge-active{background:#dcfce7;color:#166534;padding:2px 6px;border-radius:999px;font-size:8px;}
.badge-inactive{background:#fee2e2;color:#991b1b;padding:2px 6px;border-radius:999px;font-size:8px;}
</style></head><body>
<h1>Manufacturers</h1>
<p>Exported {{ now()->format('d M Y, h:i A') }} &mdash; Total: {{ $manufacturers->count() }}</p>
<table><thead><tr>
    <th>#</th><th>Company Name</th><th>Contact Person</th><th>Phone</th><th>Email</th><th>Website</th><th>Status</th>
</tr></thead><tbody>
@foreach($manufacturers as $i => $m)
<tr>
    <td>{{ $i+1 }}</td>
    <td>{{ $m->company_name }}</td>
    <td>{{ $m->contact_person ?? '-' }}</td>
    <td>{{ $m->phone ?? '-' }}</td>
    <td>{{ $m->email ?? '-' }}</td>
    <td>{{ $m->website ?? '-' }}</td>
    <td><span class="{{ $m->status==='active'?'badge-active':'badge-inactive' }}">{{ ucfirst($m->status) }}</span></td>
</tr>
@endforeach
</tbody></table></body></html>
