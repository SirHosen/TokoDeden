@extends('layouts.admin')

@section('header', 'Pengaturan Ongkos Kirim')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800">Pengaturan Ongkos Kirim</h2>
    <p class="text-gray-600 text-sm">Kelola ketentuan ongkos kirim dan lokasi toko</p>
</div>

<div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="p-6">
        <form action="{{ route('admin.shipping.update') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="free_shipping_distance" class="block text-sm font-medium text-gray-700 mb-1">Jarak Gratis Ongkir (km)</label>
                    <input type="number" name="free_shipping_distance" id="free_shipping_distance" step="0.1" min="0" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" value="{{ $shippingSetting->free_shipping_distance }}" required>
                    <p class="text-xs text-gray-500 mt-1">Jarak maksimal untuk mendapatkan gratis ongkir</p>
                </div>

                <div>
                    <label for="cost_per_km" class="block text-sm font-medium text-gray-700 mb-1">Biaya per Kilometer (Rp)</label>
                    <input type="number" name="cost_per_km" id="cost_per_km" min="0" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" value="{{ $shippingSetting->cost_per_km }}" required>
                    <p class="text-xs text-gray-500 mt-1">Biaya yang dikenakan per kilometer untuk jarak di luar gratis ongkir</p>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi Toko di Peta</label>
                <div id="map" class="w-full h-96 rounded-lg border border-gray-300 mb-2"></div>
                <p class="text-sm text-gray-500">Klik pada peta untuk menentukan lokasi toko yang tepat</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <div>
                        <label for="store_latitude" class="block text-sm font-medium text-gray-700 mb-1">Latitude Toko</label>
                        <input type="text" name="store_latitude" id="store_latitude" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" value="{{ $shippingSetting->store_latitude }}" required>
                    </div>

                    <div>
                        <label for="store_longitude" class="block text-sm font-medium text-gray-700 mb-1">Longitude Toko</label>
                        <input type="text" name="store_longitude" id="store_longitude" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" value="{{ $shippingSetting->store_longitude }}" required>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    let map, marker;

    document.addEventListener('DOMContentLoaded', function() {
        initMap();
    });

    function initMap() {
        // Initialize the map with store location
        const storeLat = {{ $shippingSetting->store_latitude }};
        const storeLng = {{ $shippingSetting->store_longitude }};

        map = L.map('map').setView([storeLat, storeLng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Set initial marker
        setMarker(storeLat, storeLng);

        // Add click event to map
        map.on('click', function(e) {
            setMarker(e.latlng.lat, e.latlng.lng);
        });
    }

    function setMarker(lat, lng) {
        // Remove existing marker
        if (marker) {
            map.removeLayer(marker);
        }

        // Add new marker
        marker = L.marker([lat, lng]).addTo(map);

        // Draw circle for free shipping radius
        const freeShippingRadius = document.getElementById('free_shipping_distance').value * 1000; // km to m

        // Remove existing circle if any
        if (window.freeShippingCircle) {
            map.removeLayer(window.freeShippingCircle);
        }

        // Add new circle
        window.freeShippingCircle = L.circle([lat, lng], {
            color: 'green',
            fillColor: '#22c55e',
            fillOpacity: 0.2,
            radius: freeShippingRadius
        }).addTo(map);

        // Set form values
        document.getElementById('store_latitude').value = lat.toFixed(8);
        document.getElementById('store_longitude').value = lng.toFixed(8);
    }

    // Update circle when free shipping distance changes
    document.getElementById('free_shipping_distance').addEventListener('input', function() {
        if (marker) {
            const lat = marker.getLatLng().lat;
            const lng = marker.getLatLng().lng;
            setMarker(lat, lng);
        }
    });
</script>
@endpush
@endsection
