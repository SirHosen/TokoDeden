<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran - {{ $order->order_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
            .no-print {
                display: none !important;
            }
            .print-break {
                page-break-after: always;
            }
            .receipt-container {
                max-width: 58mm; /* Thermal printer width */
                margin: 0 auto;
            }
        }

        .receipt-container {
            font-family: 'Courier New', monospace;
            max-width: 320px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .dashed-line {
            border-top: 1px dashed #9ca3af;
            margin: 10px 0;
        }

        .dotted-line {
            border-top: 2px dotted #6b7280;
            margin: 15px 0;
        }
    </style>
</head>
<body class="bg-gray-100 py-8">
    <div class="receipt-container">
        <!-- Header Toko -->
        <div class="text-center mb-6">
            <h1 class="text-xl font-bold text-gray-900 mb-1">TOKO DEDEN</h1>
            <p class="text-xs text-gray-600">Jl. Contoh No. 123, Jakarta</p>
            <p class="text-xs text-gray-600">Telp: (021) 1234-5678</p>
            <p class="text-xs text-gray-600">Email: info@tokodeden.com</p>
        </div>

        <div class="dotted-line"></div>

        <!-- Info Transaksi -->
        <div class="mb-4">
            <div class="flex justify-between text-xs mb-1">
                <span class="font-medium">No. Pesanan:</span>
                <span>{{ $order->order_number }}</span>
            </div>
            <div class="flex justify-between text-xs mb-1">
                <span class="font-medium">Tanggal:</span>
                <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="flex justify-between text-xs mb-1">
                <span class="font-medium">Kasir:</span>
                <span>Sistem</span>
            </div>
            <div class="flex justify-between text-xs">
                <span class="font-medium">Customer:</span>
                <span>{{ $order->user->name }}</span>
            </div>
        </div>

        <div class="dashed-line"></div>

        <!-- Detail Items -->
        <div class="mb-4">
            <h3 class="text-sm font-bold mb-2 text-center">DETAIL PESANAN</h3>

            @foreach($order->orderItems as $item)
            <div class="mb-3">
                <div class="text-xs font-medium">{{ $item->product_name }}</div>
                <div class="flex justify-between text-xs">
                    <span>{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                    <span class="font-medium">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <div class="dashed-line"></div>

        <!-- Ringkasan Pembayaran -->
        <div class="mb-4">
            <div class="flex justify-between text-xs mb-1">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($order->total_price - $order->shipping_cost, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-xs mb-1">
                <span>Ongkir ({{ number_format($order->distance, 1) }} km):</span>
                <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
            </div>
            <div class="dashed-line"></div>
            <div class="flex justify-between text-sm font-bold">
                <span>TOTAL:</span>
                <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="dashed-line"></div>

        <!-- Alamat Pengiriman -->
        <div class="mb-4">
            <h4 class="text-xs font-bold mb-1">ALAMAT PENGIRIMAN:</h4>
            <div class="text-xs text-gray-700">
                <p>{{ $order->address }}</p>
                @if($order->city)<p>{{ $order->city }}@if($order->province), {{ $order->province }}@endif</p>@endif
                @if($order->postal_code)<p>{{ $order->postal_code }}</p>@endif
            </div>
        </div>

        <div class="dashed-line"></div>

        <!-- Status & Metode Pembayaran -->
        <div class="mb-4">
            <div class="flex justify-between text-xs mb-1">
                <span class="font-medium">Status:</span>
                <span class="
                    @if($order->status == 'pending') text-yellow-600
                    @elseif($order->status == 'processing') text-blue-600
                    @elseif($order->status == 'shipped') text-purple-600
                    @elseif($order->status == 'delivered') text-green-600
                    @elseif($order->status == 'cancelled') text-red-600
                    @endif
                    font-medium
                ">{{ $order->status_name }}</span>
            </div>
            <div class="flex justify-between text-xs">
                <span class="font-medium">Pembayaran:</span>
                <span>{{ ucfirst($order->payment_method) }}</span>
            </div>
        </div>

        @if($order->notes)
        <div class="dashed-line"></div>
        <div class="mb-4">
            <h4 class="text-xs font-bold mb-1">CATATAN:</h4>
            <p class="text-xs text-gray-700">{{ $order->notes }}</p>
        </div>
        @endif

        <div class="dotted-line"></div>

        <!-- Footer -->
        <div class="text-center text-xs text-gray-600">
            <p class="mb-1">*** TERIMA KASIH ***</p>
            <p class="mb-1">Selamat berbelanja kembali!</p>
            <p class="mb-2">www.tokodeden.com</p>

            <!-- QR Code Placeholder -->
            <div class="bg-gray-100 w-16 h-16 mx-auto mb-2 flex items-center justify-center border">
                <span class="text-xs text-gray-500">QR</span>
            </div>
            <p class="text-xs">Scan untuk review & rating</p>
        </div>
    </div>

    <!-- Tombol Print -->
    <div class="text-center mt-6 no-print">
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-200 mr-3">
            <i class="fas fa-print mr-2"></i>Cetak Struk
        </button>
        <a href="{{ route('orders.show', $order) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</body>
</html>
