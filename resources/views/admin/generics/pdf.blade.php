<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Generics Export</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1e293b; }
        h1 { font-size: 16px; margin-bottom: 4px; }
        p  { color: #64748b; margin: 0 0 16px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f1f5f9; padding: 8px 10px; text-align: left; font-size: 10px; text-transform: uppercase; color: #475569; border-bottom: 2px solid #e2e8f0; }
        td { padding: 7px 10px; border-bottom: 1px solid #f1f5f9; }
        tr:nth-child(even) td { background: #f8fafc; }
        .badge-active   { background:#dcfce7; color:#166534; padding:2px 7px; border-radius:999px; font-size:9px; }
        .badge-inactive { background:#fee2e2; color:#991b1b; padding:2px 7px; border-radius:999px; font-size:9px; }
    </style>
</head>
<body>
    <h1>Generic Names</h1>
    <p>Exported on {{ now()->format('d M Y, h:i A') }} &mdash; Total: {{ $generics->count() }}</p>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Dosage</th>
                <th>Description</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($generics as $i => $g)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $g->name }}</td>
                <td>{{ $g->dosage ?? '-' }}</td>
                <td>{{ $g->description ?? '-' }}</td>
                <td><span class="{{ $g->status === 'active' ? 'badge-active' : 'badge-inactive' }}">{{ ucfirst($g->status) }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
