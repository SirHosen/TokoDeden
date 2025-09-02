<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 12px;
        }
        .header {
            padding: 20px 0;
            text-align: center;
            border-bottom: 2px solid #22c55e;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #16a34a;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
            font-size: 14px;
        }
        .info-box {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .summary-card {
            display: inline-block;
            width: 30%;
            margin-right: 3%;
            padding: 10px;
            background-color: #f9f9f9;
            border-left: 4px solid #16a34a;
            margin-bottom: 20px;
        }
        .summary-card h3 {
            margin: 0 0 5px 0;
            color: #555;
            font-size: 14px;
        }
        .summary-card p {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            color: #16a34a;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table thead th {
            background-color: #f3f4f6;
            color: #374151;
            font-weight: bold;
            text-align: left;
            padding: 10px;
            border-bottom: 2px solid #d1d5db;
        }
        table tbody td {
            padding: 8px 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .top-products {
            margin-top: 30px;
        }
        .top-products h2 {
            color: #374151;
            font-size: 16px;
            margin-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }
        .product-item {
            margin-bottom: 10px;
            padding: 5px 0;
        }
        .product-name {
            font-weight: bold;
            color: #4b5563;
        }
        .page-break {
            page-break-after: always;
        }
        .footer {
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            margin-top: 30px;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Penjualan Toko Deden</h1>
        <p>Periode: {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</p>
    </div>

    <div class="info-box">
        <div class="summary-card">
            <h3>Total Penjualan</h3>
            <p>Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
        </div>

        <div class="summary-card">
            <h3>Jumlah Pesanan</h3>
            <p>{{ $totalOrders }} Pesanan</p>
        </div>

        <div class="summary-card">
            <h3>Rata-rata Pesanan</h3>
            <p>Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</p>
        </div>
    </div>

    <h2>Daftar Pesanan</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Status</th>
                <th>Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                <td>{{ $order->user->name ?? 'N/A' }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="top-products">
        <h2>Produk Terlaris</h2>
        @if($productSales->isEmpty())
            <p>Tidak ada data penjualan produk dalam periode ini.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah Terjual</th>
                        <th>Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productSales as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->total_quantity }} unit</td>
                        <td>Rp {{ number_format($product->total_revenue, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="footer">
        <p>Laporan ini digenerate otomatis pada {{ now()->format('d M Y H:i:s') }}</p>
        <p>© {{ date('Y') }} Toko Deden - Dokumen ini bersifat rahasia</p>
    </div>
</body>
</html>
