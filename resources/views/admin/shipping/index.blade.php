@extends('layouts.admin')

@section('header', 'Pengaturan Ongkos Kirim')

@section('content')
<div class="flex justify-between items-start mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Kelola ketentuan biaya pengiriman dan lokasi toko</h2>
        <p class="text-gray-600"></p>
    </div>
    <div>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
            <i class="fas fa-info-circle mr-1"></i> Pengaturan Aktif
        </span>
    </div>
</div>

<div class="bg-white shadow-lg rounded-xl overflow-hidden">
    <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4">
        <h3 class="text-white font-semibold text-lg">Konfigurasi Biaya Pengiriman</h3>
    </div>
    <div class="p-6">
        <form action="{{ route('admin.shipping.update') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="bg-gray-50 p-5 rounded-lg border border-gray-100">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-truck text-green-600"></i>
                        </div>
                        <label for="free_shipping_distance" class="block text-base font-medium text-gray-800">Jarak Gratis Ongkir</label>
                    </div>
                    <div class="relative">
                        <input type="number" name="free_shipping_distance" id="free_shipping_distance" step="0.1" min="0"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-500 shadow-sm"
                               value="{{ $shippingSetting->free_shipping_distance }}" required>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <span class="text-gray-500 font-medium">km</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mt-2 flex items-center">
                        <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                        Jarak maksimal untuk mendapatkan pengiriman gratis
                    </p>
                </div>

                <div class="bg-gray-50 p-5 rounded-lg border border-gray-100">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-coins text-yellow-600"></i>
                        </div>
                        <label for="cost_per_km" class="block text-base font-medium text-gray-800">Biaya per Kilometer</label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <span class="text-gray-500 font-medium">Rp</span>
                        </div>
                        <input type="number" name="cost_per_km" id="cost_per_km" min="0"
                               class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-500 shadow-sm"
                               value="{{ $shippingSetting->cost_per_km }}" required>
                    </div>
                    <p class="text-sm text-gray-500 mt-2 flex items-center">
                        <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                        Biaya yang dikenakan per kilometer untuk jarak di luar area gratis
                    </p>
                </div>
            </div>

            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-map-marker-alt text-blue-600"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-800">Lokasi Toko di Peta</h3>
                </div>

                <div class="bg-white p-1 rounded-xl border border-gray-200 shadow-md">
                    <div id="map" class="w-full h-96 rounded-lg overflow-hidden"></div>
                </div>
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mt-3 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-800">Klik pada peta untuk menentukan lokasi toko yang tepat. Area lingkaran hijau menunjukkan jangkauan pengiriman gratis.</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 bg-gray-50 p-5 rounded-lg border border-gray-100">
                    <div>
                        <label for="store_latitude" class="flex items-center text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-location-arrow text-gray-500 mr-2"></i> Latitude Toko
                        </label>
                        <input type="text" name="store_latitude" id="store_latitude"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-500 shadow-sm font-mono"
                               value="{{ $shippingSetting->store_latitude }}" required>
                    </div>

                    <div>
                        <label for="store_longitude" class="flex items-center text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-location-arrow text-gray-500 mr-2"></i> Longitude Toko
                        </label>
                        <input type="text" name="store_longitude" id="store_longitude"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-500 shadow-sm font-mono"
                               value="{{ $shippingSetting->store_longitude }}" required>
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-8">
                <button type="submit" class="flex items-center bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium py-3 px-8 rounded-lg transition-all shadow-md hover:shadow-lg">
                    <i class="fas fa-save mr-2"></i> Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Shipping Simulation Card -->
<div class="bg-white shadow-lg rounded-xl overflow-hidden mt-8">
    <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4">
        <h3 class="text-white font-semibold text-lg">Simulasi Perhitungan Ongkir</h3>
    </div>
    <div class="p-6">
        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
            <h4 class="text-lg font-medium text-gray-800 mb-4">Hitung Biaya Pengiriman</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jarak dari Toko (km)</label>
                    <input type="number" id="simulation_distance" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-500 shadow-sm" value="5" min="0" step="0.1">
                </div>
                <div class="flex flex-col justify-end">
                    <button id="calculate_btn" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-all">
                        Hitung Biaya
                    </button>
                </div>
            </div>

            <div id="simulation_result" class="mt-5 hidden">
                <hr class="my-4 border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-600">Hasil perhitungan:</p>
                        <p class="text-xl font-bold text-gray-800" id="shipping_cost_result">Rp 0</p>
                    </div>
                    <div class="bg-gray-100 px-4 py-2 rounded-lg">
                        <span id="shipping_status" class="text-sm font-medium"></span>
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
    let map, marker;

    document.addEventListener('DOMContentLoaded', function() {
        initMap();
        initSimulator();
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

        // Improve map UI with zoom controls in the top-right corner
        map.zoomControl.setPosition('topright');

        // Add scale control
        L.control.scale({imperial: false}).addTo(map);
    }

    function setMarker(lat, lng) {
        // Remove existing marker
        if (marker) {
            map.removeLayer(marker);
        }

        // Add custom icon for store marker
        const storeIcon = L.divIcon({
            html: '<i class="fas fa-store text-2xl text-green-700"></i>',
            className: 'store-marker-icon',
            iconSize: [40, 40],
            iconAnchor: [20, 20]
        });

        // Add new marker
        marker = L.marker([lat, lng], {
            icon: storeIcon,
            title: 'Lokasi Toko'
        }).addTo(map);

        // Add popup
        marker.bindPopup("<strong>Lokasi Toko Deden</strong><br>Pusat pengiriman").openPopup();

        // Draw circle for free shipping radius
        const freeShippingRadius = document.getElementById('free_shipping_distance').value * 1000; // km to m

        // Remove existing circle if any
        if (window.freeShippingCircle) {
            map.removeLayer(window.freeShippingCircle);
        }

        // Add new circle with improved styling
        window.freeShippingCircle = L.circle([lat, lng], {
            color: '#16a34a',
            weight: 2,
            dashArray: '5, 5',
            fillColor: '#22c55e',
            fillOpacity: 0.15,
            radius: freeShippingRadius
        }).addTo(map);

        // Add circle label
        window.freeShippingCircle.bindTooltip("Area Gratis Ongkir",
            { permanent: true, direction: 'center', className: 'circle-label' }
        );

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

    // Shipping cost simulator
    function initSimulator() {
        document.getElementById('calculate_btn').addEventListener('click', function() {
            const distance = parseFloat(document.getElementById('simulation_distance').value);
            const freeShippingDistance = parseFloat(document.getElementById('free_shipping_distance').value);
            const costPerKm = parseFloat(document.getElementById('cost_per_km').value);

            let cost = 0;
            let status = '';

            if (distance <= freeShippingDistance) {
                cost = 0;
                status = '<span class="text-green-600">Gratis Ongkir</span>';
            } else {
                const extraDistance = distance - freeShippingDistance;
                cost = extraDistance * costPerKm;
                status = '<span class="text-blue-600">Berbayar</span>';
            }

            document.getElementById('shipping_cost_result').textContent = 'Rp ' + numberWithCommas(cost);
            document.getElementById('shipping_status').innerHTML = status;
            document.getElementById('simulation_result').classList.remove('hidden');
        });
    }

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>

<style>
    .store-marker-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: white;
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        width: 40px !important;
        height: 40px !important;
        margin-left: -20px !important;
        margin-top: -20px !important;
    }
    .circle-label {
        background-color: transparent;
        border: none;
        box-shadow: none;
        color: #16a34a;
        font-weight: bold;
        font-size: 14px;
        text-shadow: 0 0 3px white;
    }
</style>
@endpush
@endsection
