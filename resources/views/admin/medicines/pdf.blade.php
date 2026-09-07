<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Medicine List Export - Pharmacy RMS</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #0d9488; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #0d9488; font-size: 24px; }
        .header p { margin: 4px 0 0; color: #666; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #cbd5e1; padding: 6px 8px; text-align: left; vertical-align: middle; }
        th { background-color: #f1f5f9; font-weight: bold; color: #334155; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .price { font-weight: bold; color: #0f172a; }
        .img-thumb { width: 38px; height: 38px; object-fit: cover; border-radius: 6px; border: 1px solid #cbd5e1; display: inline-block; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 15px;">
        <button onclick="window.print()" style="background:#0d9488; color:white; border:none; padding:8px 16px; font-weight:bold; border-radius:6px; cursor:pointer;">Print / Save PDF</button>
        <button onclick="window.close()" style="background:#64748b; color:white; border:none; padding:8px 16px; font-weight:bold; border-radius:6px; cursor:pointer; margin-left:10px;">Close Window</button>
    </div>

    <div class="header">
        <h1>Pharmacy Management System</h1>
        <p>Medicine Directory Report with Product Images — Generated on {{ date('d M, Y h:i A') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 35px;">SL</th>
                <th style="width: 50px;" class="text-center">Image</th>
                <th>Medicine Name</th>
                <th>Generic Name</th>
                <th>Manufacturer</th>
                <th>Category</th>
                <th>Strength</th>
                <th class="text-right">Sale Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($medicines as $index => $item)
            @php
                $imgUrl = $item->product_images->first()->image_url ?? $item->image ?? null;
                if ($imgUrl && !str_starts_with($imgUrl, 'http')) {
                    $imgUrl = asset('storage/' . $imgUrl);
                }
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">
                    @if($imgUrl)
                        <img src="{{ $imgUrl }}" alt="{{ $item->name }}" class="img-thumb">
                    @else
                        -
                    @endif
                </td>
                <td><strong>{{ $item->name }}</strong></td>
                <td>{{ $item->generic->name ?? '-' }}</td>
                <td>{{ $item->manufacturer->company_name ?? '-' }}</td>
                <td>{{ $item->category->name ?? '-' }}</td>
                <td>{{ $item->strength }}</td>
                <td class="text-right price">৳ {{ number_format($item->sale_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        // Auto trigger print window
        window.onload = function() {
            setTimeout(function() { window.print(); }, 500);
        };
    </script>
</body>
</html>
