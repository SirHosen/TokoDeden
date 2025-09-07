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

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon *</label>
            <input id="phone" name="phone" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('phone', $user->phone) }}" required />
        </div>

        <div>
            <label for="address_name" class="block text-sm font-medium text-gray-700">Nama Alamat</label>
            <input id="address_name" name="address_name" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('address_name', $user->address_name) }}" placeholder="Rumah, Kantor, dll." />
        </div>

        <div>
            <label for="address" class="block text-sm font-medium text-gray-700">Alamat Lengkap *</label>
            <input id="address" name="address" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('address', $user->address) }}" required />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700">Kota</label>
                <input id="city" name="city" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('city', $user->city) }}" />
            </div>

            <div>
                <label for="province" class="block text-sm font-medium text-gray-700">Provinsi</label>
                <input id="province" name="province" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('province', $user->province) }}" />
            </div>
        </div>

        <div>
            <label for="postal_code" class="block text-sm font-medium text-gray-700">Kode Pos</label>
            <input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('postal_code', $user->postal_code) }}" />
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="is_default_address" id="is_default_address" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ old('is_default_address', $user->is_default_address) ? 'checked' : '' }}>
            <label for="is_default_address" class="ml-2 text-sm text-gray-600">{{ __('Jadikan alamat default untuk checkout') }}</label>
        </div>

        <div class="mt-4">
            <label for="map-container" class="block text-sm font-medium text-gray-700">Pilih Lokasi di Peta</label>
            <div id="map-container" class="w-full h-64 rounded-lg border border-gray-300 mt-1"></div>
            <p class="mt-1 text-xs text-gray-500">Klik pada peta untuk menandai lokasi Anda</p>
        </div>

        <div class="mt-2">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                    <input id="latitude" name="latitude" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('latitude', $user->latitude) }}" />
                </div>
                <div>
                    <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                    <input id="longitude" name="longitude" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('longitude', $user->longitude) }}" />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Simpan') }}
            </button>

            @if (session('status') === 'address-updated')
                <p class="text-sm text-green-600">
                    {{ __('Tersimpan.') }}
                </p>
            @endif
        </div>
    </form>

    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        .leaflet-container {
            height: 100%;
            width: 100%;
        }
        #map-container {
            min-height: 300px;
            width: 100%;
            z-index: 10;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        // Wait for the document to fully load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Document loaded, initializing map');

            // Default coordinates (Jakarta or user's saved location)
            const defaultLat = {{ $user->latitude ?? -6.2088 }};
            const defaultLng = {{ $user->longitude ?? 106.8456 }};
            console.log('Profile map using coordinates:', defaultLat, defaultLng);

            // Set the initial values in the visible fields
            document.getElementById('latitude').value = defaultLat;
            document.getElementById('longitude').value = defaultLng;

            let map, marker;

            // Wait a moment before initializing the map to ensure container is ready
            setTimeout(() => {
                try {
                    console.log('Creating map in map-container element');

                    // Initialize the map
                    map = L.map('map-container').setView([defaultLat, defaultLng], 15);

                    // Add the tile layer (OpenStreetMap)
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);

                    // Add marker at the default position
                    marker = L.marker([defaultLat, defaultLng], {
                        draggable: true,
                        title: "Lokasi Anda"
                    }).addTo(map);

                    // Make sure the map is properly sized
                    map.invalidateSize();

                    // Event: When marker is dragged
                    marker.on('dragend', function() {
                        const position = marker.getLatLng();
                        updateCoordinates(position.lat, position.lng);
                    });

                    // Event: When map is clicked
                    map.on('click', function(e) {
                        marker.setLatLng(e.latlng);
                        updateCoordinates(e.latlng.lat, e.latlng.lng);
                    });

                    // Try to get user's current location
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                const pos = {
                                    lat: position.coords.latitude,
                                    lng: position.coords.longitude,
                                };
                                map.setView([pos.lat, pos.lng], 15);
                                marker.setLatLng([pos.lat, pos.lng]);
                                updateCoordinates(pos.lat, pos.lng);
                            },
                            (error) => {
                                console.log('Geolocation error:', error);
                            }
                        );
                    }

                    console.log('Map initialized successfully');
                } catch (error) {
                    console.error('Error initializing map:', error);
                }
            }, 300);

            // Update coordinates and get address information
            function updateCoordinates(lat, lng) {
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
                getAddressFromLatLng(lat, lng);
            }

            // Get address details from coordinates using Nominatim
            function getAddressFromLatLng(lat, lng) {
                console.log('Getting address for:', lat, lng);

                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`, {
                    headers: {
                        'Accept-Language': 'id',
                        'User-Agent': 'TokoDeden Laravel Application'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Nominatim response:', data);

                    if (data && data.address) {
                        const addr = data.address;

                        // Build address string
                        let address = '';
                        if (addr.road) address += addr.road;
                        if (addr.house_number) address += ' ' + addr.house_number;
                        if (address === '' && addr.suburb) address = addr.suburb;

                        // Get other address components
                        const city = addr.city || addr.town || addr.village || addr.suburb || '';
                        const province = addr.state || '';
                        const postal_code = addr.postcode || '';

                        // Update form fields
                        if (address) document.getElementById('address').value = address;
                        if (city) document.getElementById('city').value = city;
                        if (province) document.getElementById('province').value = province;
                        if (postal_code) document.getElementById('postal_code').value = postal_code;

                        console.log('Address fields updated');
                    }
                })
                .catch(error => {
                    console.error('Error getting address:', error);
                });
            }
        });
    </script>
    @endpush
</section>
