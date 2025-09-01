<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-green-600">
                            <i class="fas fa-home mr-2"></i> Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <a href="{{ route('orders.index') }}" class="text-gray-700 hover:text-green-600">
                                Pesanan Saya
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="text-gray-500">Detail Pesanan</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="bg-white shadow rounded-lg mb-6">
                <div class="border-b border-gray-200 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Pesanan #{{ $order->order_number }}</h3>
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                            @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                            @elseif($order->status == 'shipped') bg-indigo-100 text-indigo-800
                            @elseif($order->status == 'delivered') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            @if($order->status == 'pending') Menunggu Konfirmasi
                            @elseif($order->status == 'processing') Diproses
                            @elseif($order->status == 'shipped') Dikirim
                            @elseif($order->status == 'delivered') Selesai
                            @else Dibatalkan @endif
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">Tanggal Pesanan: {{ $order->created_at->format('d M Y, H:i') }}</p>
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

            <!-- Shipping and Payment Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white shadow rounded-lg p-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pengiriman</h4>
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-1">Alamat Pengiriman:</p>
                        <p class="text-sm font-medium text-gray-800">{{ $order->address }}</p>
                    </div>
                    <div>
                        <div id="map" class="w-full h-48 rounded-lg border"></div>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pembayaran</h4>
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-1">Metode Pembayaran:</p>
                        <p class="text-sm font-medium text-gray-800">
                            @if($order->payment_method == 'transfer')
                                Transfer Bank
                            @else
                                Bayar di Tempat (COD)
                            @endif
                        </p>
                    </div>
                    @if($order->payment_method == 'transfer')
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h5 class="text-sm font-semibold text-gray-800 mb-2">Instruksi Pembayaran:</h5>
                            <p class="text-sm text-gray-600 mb-2">Silakan transfer sesuai dengan total pembayaran ke:</p>
                            <div class="text-sm text-gray-800">
                                <p>Bank BCA</p>
                                <p>No. Rekening: 1234567890</p>
                                <p>Atas Nama: PT. Toko Deden</p>
                            </div>
                        </div>
                    @endif

                    @if($order->notes)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-600 mb-1">Catatan:</p>
                            <p class="text-sm text-gray-800">{{ $order->notes }}</p>
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
            L.marker([{{ $order->latitude }}, {{ $order->longitude }}]).addTo(map);
        });
    </script>
    @endpush
</x-app-layout>
