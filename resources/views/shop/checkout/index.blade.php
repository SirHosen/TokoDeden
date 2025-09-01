<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-6">Checkout</h1>

            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Checkout Form -->
                <div class="lg:w-2/3">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold mb-4">Detail Pengiriman</h3>

                        <form id="checkout-form" action="{{ route('checkout.process') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="text" name="name" id="name" value="{{ $user->name }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" readonly>
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" id="email" value="{{ $user->email }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" readonly>
                            </div>

                            <div class="mb-4">
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                                <input type="text" name="phone" id="phone" value="{{ $user->phone }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" readonly>
                            </div>

                            <div class="mb-4">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Pengiriman <span class="text-red-500">*</span></label>
                                <textarea name="address" id="address" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" required>{{ $user->address }}</textarea>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi di Peta <span class="text-red-500">*</span></label>
                                <div id="map" class="w-full h-64 rounded-lg border border-gray-300 mb-2"></div>
                                <p class="text-sm text-gray-500">Klik pada peta untuk menentukan lokasi pengiriman yang tepat</p>
                                <input type="hidden" name="latitude" id="latitude" required>
                                <input type="hidden" name="longitude" id="longitude" required>
                                <div id="distance-info" class="mt-2 p-3 bg-blue-50 text-blue-800 rounded-lg hidden">
                                    <p><i class="fas fa-info-circle mr-2"></i> <span id="distance-text"></span></p>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-6 mb-6">
                                <h3 class="text-lg font-semibold mb-4">Metode Pembayaran</h3>
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <input type="radio" name="payment_method" id="transfer" value="transfer" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300" checked>
                                        <label for="transfer" class="ml-3 block text-sm font-medium text-gray-700">
                                            Transfer Bank
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" name="payment_method" id="cod" value="cod" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                        <label for="cod" class="ml-3 block text-sm font-medium text-gray-700">
                                            Bayar di Tempat (COD)
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan Pesanan</label>
                                <textarea name="notes" id="notes" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" placeholder="Informasi tambahan untuk pesanan Anda"></textarea>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:w-1/3">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold mb-4">Ringkasan Pesanan</h3>
                        <div class="max-h-64 overflow-y-auto mb-4">
                            @foreach($cartItems as $item)
                                <div class="flex items-start py-3 {{ !$loop->first ? 'border-t border-gray-200' : '' }}">
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-16 w-16 object-cover rounded">
                                    <div class="ml-4 flex-1">
                                        <div class="flex justify-between">
                                            <h4 class="text-sm font-medium text-gray-900">{{ $item->product->name }}</h4>
                                            <p class="text-sm font-medium text-gray-900">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                                        </div>
                                        <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Ongkos Kirim</span>
                                <span class="font-medium" id="shipping-cost">Rp 0</span>
                            </div>
                            <div class="border-t border-gray-200 mt-4 pt-4">
                                <div class="flex justify-between">
                                    <span class="text-lg font-semibold">Total</span>
                                    <span class="text-lg font-bold text-green-600" id="total-price">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="mt-6">
                                <button type="button" onclick="submitCheckout()" class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition duration-300 flex items-center justify-center">
                                    <i class="fas fa-lock mr-2"></i> Buat Pesanan
                                </button>
                            </div>
                        </div>
                    </div>
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
        let map, marker, subtotal = {{ $subtotal }};
        let shippingCost = 0;

        document.addEventListener('DOMContentLoaded', function() {
            initMap();
        });

        function initMap() {
            // Initialize the map (center it on a default location)
            map = L.map('map').setView([-6.175110, 106.865039], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Set marker if user already has coordinates
            @if($user->latitude && $user->longitude)
                setMarker({{ $user->latitude }}, {{ $user->longitude }});
                calculateShipping({{ $user->latitude }}, {{ $user->longitude }});
            @endif

            // Add click event to map
            map.on('click', function(e) {
                setMarker(e.latlng.lat, e.latlng.lng);
                calculateShipping(e.latlng.lat, e.latlng.lng);
            });
        }

        function setMarker(lat, lng) {
            // Remove existing marker
            if (marker) {
                map.removeLayer(marker);
            }

            // Add new marker
            marker = L.marker([lat, lng]).addTo(map);

            // Set form values
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        }

        function calculateShipping(lat, lng) {
            fetch('{{ route("checkout.shipping") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    latitude: lat,
                    longitude: lng
                })
            })
            .then(response => response.json())
            .then(data => {
                shippingCost = data.shipping_cost;
                document.getElementById('shipping-cost').innerText = data.formatted_shipping_cost;
                document.getElementById('total-price').innerText = 'Rp ' + numberFormat(subtotal + shippingCost);

                // Show distance info
                document.getElementById('distance-info').classList.remove('hidden');

                if (data.distance <= 2) {
                    document.getElementById('distance-text').innerText = 'Jarak pengiriman ' + data.distance + ' km (Gratis Ongkir)';
                } else {
                    document.getElementById('distance-text').innerText = 'Jarak pengiriman ' + data.distance + ' km';
                }
            })
            .catch(error => {
                console.error('Error calculating shipping:', error);
            });
        }

        function numberFormat(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        }

        function submitCheckout() {
            const form = document.getElementById('checkout-form');

            // Validate location is selected
            if (!document.getElementById('latitude').value || !document.getElementById('longitude').value) {
                alert('Silakan pilih lokasi pengiriman di peta.');
                return;
            }

            form.submit();
        }
    </script>
    @endpush
</x-app-layout>
