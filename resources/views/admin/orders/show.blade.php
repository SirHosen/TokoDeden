@extends('layouts.admin')

@section('header', 'Detail Pesanan')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.orders.index') }}" class="text-green-600 hover:text-green-800">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Pesanan
    </a>
</div>

<div class="bg-white shadow rounded-lg mb-6">
    <div class="border-b border-gray-200 px-6 py-4">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Pesanan #{{ $order->order_number }}</h3>
            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-800">
                {{ $order->status_name }}
            </span>
        </div>
        <p class="text-sm text-gray-600 mt-1">Tanggal Pesanan: {{ $order->created_at->format('d M Y, H:i') }}</p>

        <!-- Order Progress -->
        <div class="mt-6 mb-4">
            <div class="relative">
                <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-200">
                    @php
                        $progressWidth = match($order->status) {
                            'pending' => '20%',
                            'processing' => '40%',
                            'shipped' => '60%',
                            'delivered' => '100%',
                            'cancelled' => '100%',
                            'rejected' => '100%',
                            default => '0%',
                        };

                        $progressColor = match($order->status) {
                            'pending' => 'bg-yellow-500',
                            'processing' => 'bg-blue-500',
                            'shipped' => 'bg-indigo-500',
                            'delivered' => 'bg-green-500',
                            'cancelled' => 'bg-red-500',
                            'rejected' => 'bg-red-500',
                            default => 'bg-gray-500',
                        };
                    @endphp
                    <div style="width: {{ $progressWidth }}" class="{{ $progressColor }} rounded transition-all duration-500"></div>
                </div>
                <div class="flex justify-between text-xs mt-2">
                    <div class="{{ $order->status == 'pending' ? 'font-bold text-yellow-600' : '' }}">Konfirmasi</div>
                    <div class="{{ $order->status == 'processing' ? 'font-bold text-blue-600' : '' }}">Diproses</div>
                    <div class="{{ $order->status == 'shipped' ? 'font-bold text-indigo-600' : '' }}">Dikirim</div>
                    <div class="{{ $order->status == 'delivered' ? 'font-bold text-green-600' : ($order->status == 'cancelled' || $order->status == 'rejected' ? 'font-bold text-red-600' : '') }}">
                        {{ ($order->status == 'cancelled') ? 'Dibatalkan' : (($order->status == 'rejected') ? 'Ditolak' : 'Selesai') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div class="flex flex-wrap gap-2 mb-4">
                @if($order->status == 'pending')
                    <form action="{{ route('admin.orders.confirm', $order) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg text-sm flex items-center">
                            <i class="fas fa-check mr-2"></i> Konfirmasi Pesanan
                        </button>
                    </form>

                    <form action="{{ route('admin.orders.reject', $order) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menolak pesanan ini?');">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg text-sm flex items-center">
                            <i class="fas fa-times mr-2"></i> Tolak Pesanan
                        </button>
                    </form>
                @endif

                @if($order->status == 'processing')
                    <form action="{{ route('admin.orders.ship', $order) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg text-sm flex items-center">
                            <i class="fas fa-shipping-fast mr-2"></i> Kirim Pesanan
                        </button>
                    </form>

                    <form action="{{ route('admin.orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg text-sm flex items-center">
                            <i class="fas fa-ban mr-2"></i> Batalkan Pesanan
                        </button>
                    </form>
                @endif

                @if($order->status == 'shipped')
                    <div class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-lg text-sm flex items-center">
                        <i class="fas fa-info-circle mr-2"></i> Pesanan telah dikirim. Menunggu konfirmasi penerimaan oleh pelanggan.
                    </div>
                @endif

                @if(in_array($order->status, ['delivered', 'cancelled', 'rejected']))
                    <div class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm">
                        Pesanan ini telah mencapai status final dan tidak dapat diubah lagi.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Customer Information -->
    <div class="px-6 py-4 border-b border-gray-200">
        <h4 class="text-md font-semibold text-gray-800 mb-3">Informasi Pelanggan</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-600 mb-1">Nama:</p>
                <p class="text-sm font-medium text-gray-800">{{ $order->user->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Email:</p>
                <p class="text-sm font-medium text-gray-800">{{ $order->user->email }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Telepon:</p>
                <p class="text-sm font-medium text-gray-800">{{ $order->user->phone }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Metode Pembayaran:</p>
                <p class="text-sm font-medium text-gray-800">
                    @if($order->payment_method == 'transfer')
                        Transfer Bank
                    @else
                        Bayar di Tempat (COD)
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="px-6 py-4">
        <h4 class="text-md font-semibold text-gray-800 mb-4">Produk yang Dibeli</h4>
        <div class="border rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Produk
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Harga
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jumlah
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Subtotal
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($order->orderItems as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($item->product)
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product_name }}">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->product_name }}</div>
                                        </div>
                                    @else
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->product_name }}</div>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $item->quantity }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Order Summary -->
    <div class="px-6 py-4 bg-gray-50 border-t">
        <div class="flex justify-between items-center mb-2">
            <span class="text-sm text-gray-600">Subtotal</span>
            <span class="text-sm font-medium">Rp {{ number_format($order->total_price - $order->shipping_cost, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between items-center mb-2">
            <span class="text-sm text-gray-600">Ongkos Kirim ({{ number_format($order->distance, 1) }} km)</span>
            <span class="text-sm font-medium">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-200">
            <span class="text-base font-semibold text-gray-800">Total</span>
            <span class="text-base font-bold text-green-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
        </div>
    </div>
</div>

<!-- Shipping and Address Information -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pengiriman</h4>
        <div class="mb-4">
            <p class="text-sm text-gray-600 mb-1">Alamat Pengiriman:</p>
            <p class="text-sm font-medium text-gray-800">{{ $order->address }}</p>
        </div>
        <div>
            <div id="map" class="w-full h-64 rounded-lg border"></div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">Detail Tambahan</h4>
        @if($order->notes)
            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-1">Catatan Pesanan:</p>
                <p class="text-sm font-medium text-gray-800">{{ $order->notes }}</p>
            </div>
        @endif

        <div>
            <p class="text-sm text-gray-600 mb-1">Riwayat Status:</p>
            <div class="space-y-3 mt-2">
                <div class="flex items-center">
                    <div class="bg-green-100 rounded-full p-2 mr-3">
                        <i class="fas fa-shopping-cart text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">Pesanan Dibuat</p>
                        <p class="text-xs text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                @if($order->status != 'pending')
                <div class="flex items-center">
                    <div class="bg-blue-100 rounded-full p-2 mr-3">
                        <i class="fas fa-check text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">Pesanan Diproses</p>
                        <p class="text-xs text-gray-500">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                @endif

                @if($order->status == 'shipped' || $order->status == 'delivered')
                <div class="flex items-center">
                    <div class="bg-indigo-100 rounded-full p-2 mr-3">
                        <i class="fas fa-truck text-indigo-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">Pesanan Dikirim</p>
                        <p class="text-xs text-gray-500">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                @endif

                @if($order->status == 'delivered')
                <div class="flex items-center">
                    <div class="bg-green-100 rounded-full p-2 mr-3">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">Pesanan Selesai</p>
                        <p class="text-xs text-gray-500">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                @endif

                @if($order->status == 'cancelled')
                <div class="flex items-center">
                    <div class="bg-red-100 rounded-full p-2 mr-3">
                        <i class="fas fa-times-circle text-red-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">Pesanan Dibatalkan</p>
                        <p class="text-xs text-gray-500">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const map = L.map('map').setView([{{ $order->latitude }}, {{ $order->longitude }}], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Add marker for delivery location
        L.marker([{{ $order->latitude }}, {{ $order->longitude }}]).addTo(map)
            .bindPopup("Lokasi Pengiriman")
            .openPopup();
    });
</script>
@endpush
@endsection
