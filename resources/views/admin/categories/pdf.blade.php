<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Categories PDF</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; padding: 20px; }
        h1 { font-size: 18px; margin-bottom: 4px; color: #1e293b; }
        p.sub { font-size: 11px; color: #64748b; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #0f766e; color: #fff; }
        th, td { padding: 7px 10px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        .badge-active { background: #dcfce7; color: #166534; padding: 2px 8px; border-radius: 12px; font-size: 10px; }
        .badge-inactive { background: #fee2e2; color: #991b1b; padding: 2px 8px; border-radius: 12px; font-size: 10px; }
    </style>
</head>
<body>
    <h1>Categories List</h1>
    <p class="sub">Generated on {{ now()->format('d M Y, h:i A') }} &mdash; Total: {{ $categories->count() }}</p>
    <table>
        <thead>
            <tr>
                <th style="width:40px">SL</th>
                <th>Name</th>
                <th>Parent Category</th>
                <th>Description</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $i => $cat)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $cat->name }}</td>
                <td>{{ $cat->category->name ?? '-' }}</td>
                <td>{{ $cat->description ?? '-' }}</td>
                <td>
                    @if($cat->status === 'active')
                        <span class="badge-active">Active</span>
                    @else
                        <span class="badge-inactive">Inactive</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
