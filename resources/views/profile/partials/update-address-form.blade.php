<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Alamat') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Perbarui alamat dan informasi lokasi Anda untuk pengiriman pesanan.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update.address') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="phone" :value="__('Nomor Telepon')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" required />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div>
            <x-input-label for="address_name" :value="__('Nama Alamat')" />
            <x-text-input id="address_name" name="address_name" type="text" class="mt-1 block w-full" :value="old('address_name', $user->address_name)" placeholder="Rumah, Kantor, dll." />
            <x-input-error class="mt-2" :messages="$errors->get('address_name')" />
        </div>

        <div>
            <x-input-label for="address" :value="__('Alamat Lengkap')" />
            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->address)" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="city" :value="__('Kota')" />
                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $user->city)" />
                <x-input-error class="mt-2" :messages="$errors->get('city')" />
            </div>

            <div>
                <x-input-label for="province" :value="__('Provinsi')" />
                <x-text-input id="province" name="province" type="text" class="mt-1 block w-full" :value="old('province', $user->province)" />
                <x-input-error class="mt-2" :messages="$errors->get('province')" />
            </div>
        </div>

        <div>
            <x-input-label for="postal_code" :value="__('Kode Pos')" />
            <x-text-input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full" :value="old('postal_code', $user->postal_code)" />
            <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="is_default_address" id="is_default_address" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ old('is_default_address', $user->is_default_address) ? 'checked' : '' }}>
            <label for="is_default_address" class="ml-2 text-sm text-gray-600">{{ __('Jadikan alamat default untuk checkout') }}</label>
        </div>

        <div class="mt-4">
            <x-input-label for="map-container" :value="__('Pilih Lokasi di Peta')" />
            <div id="map-container" class="w-full h-64 rounded-lg border border-gray-300 mt-1"></div>
            <p class="mt-1 text-xs text-gray-500">Klik pada peta untuk menandai lokasi Anda</p>
        </div>

        <input type="hidden" name="latitude" id="latitude" value="{{ $user->latitude }}">
        <input type="hidden" name="longitude" id="longitude" value="{{ $user->longitude }}">

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'address-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>

    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    @endpush

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        let map;
        let marker;

        document.addEventListener('DOMContentLoaded', function() {
            initMap();
        });

        function initMap() {
            // Default coordinates (Jakarta)
            let defaultLat = {{ $user->latitude ?? -6.2088 }};
            let defaultLng = {{ $user->longitude ?? 106.8456 }};

            // Create a map centered at the default location or user's saved location
            try {
                map = L.map('map-container').setView([defaultLat, defaultLng], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Force a map refresh
                setTimeout(function() {
                    map.invalidateSize();
                }, 100);

            // Add a marker at the center
            marker = L.marker([defaultLat, defaultLng], {
                draggable: true,
                title: "Lokasi Anda"
            }).addTo(map);

            // Update hidden inputs when marker is dragged
            marker.on('dragend', function() {
                const position = marker.getLatLng();
                document.getElementById('latitude').value = position.lat;
                document.getElementById('longitude').value = position.lng;
                getAddressFromLatLng(position.lat, position.lng);
            });

            // Allow clicking on map to move the marker
            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                document.getElementById('latitude').value = e.latlng.lat;
                document.getElementById('longitude').value = e.latlng.lng;
                getAddressFromLatLng(e.latlng.lat, e.latlng.lng);
            });

            // Try to get user's location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        };
                        map.setView([pos.lat, pos.lng], 15);
                        marker.setLatLng([pos.lat, pos.lng]);
                        document.getElementById('latitude').value = pos.lat;
                        document.getElementById('longitude').value = pos.lng;
                        getAddressFromLatLng(pos.lat, pos.lng);
                    },
                    () => {
                        // Handle location error
                    }
                );
            }
        }

        function getAddressFromLatLng(lat, lng) {
            // Using Nominatim for reverse geocoding
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`, {
                headers: {
                    'Accept-Language': 'id',
                    'User-Agent': 'TokoDeden Laravel Application'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data && data.address) {
                        const addr = data.address;

                        // Extract address components
                        let address = '';
                        if (addr.road) address += addr.road;
                        if (addr.house_number) address += ' ' + addr.house_number;

                        const city = addr.city || addr.town || addr.village || addr.suburb || '';
                        const province = addr.state || '';
                        const postal_code = addr.postcode || '';

                        // Update form fields with retrieved values
                        if (address) document.getElementById('address').value = address;
                        if (city) document.getElementById('city').value = city;
                        if (province) document.getElementById('province').value = province;
                        if (postal_code) document.getElementById('postal_code').value = postal_code;
                    }
                })
                .catch(error => {
                    console.error('Error getting address:', error);
                });
        }
    </script>
    @endpush
</section>
