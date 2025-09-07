@extends('layouts.admin')

@section('header', 'Edit Pengguna')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    #map-admin {
        min-height: 300px;
        width: 100%;
        z-index: 10;
    }
</style>
@endpush

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-gray-600 hover:text-green-600 transition-colors">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Pengguna
    </a>
</div>

<div class="bg-white shadow-lg rounded-xl overflow-hidden">
    <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4">
        <h3 class="text-white font-semibold text-lg">Edit Pengguna</h3>
    </div>
    <div class="p-6">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-semibold text-gray-700 mb-4">Informasi Dasar</h4>

                    <div class="mb-5">
                        <label for="name" class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                        <input type="email" name="email" id="email" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="phone" class="block text-gray-700 font-medium mb-2">Nomor Telepon</label>
                        <input type="text" name="phone" id="phone" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" value="{{ old('phone', $user->phone) }}">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <input type="hidden" name="role_id" value="{{ $user->role_id }}">

                    <div class="mb-5">
                        <label for="is_active" class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" class="rounded border-gray-300 text-green-600 focus:ring-green-600" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700 font-medium">Akun Aktif</span>
                        </label>
                        @error('is_active')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="password" class="block text-gray-700 font-medium mb-2">Password Baru (kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" id="password" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent">
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-700 mb-4">Informasi Lainnya</h4>

                    <div class="mb-5">
                        <label class="block text-gray-700 font-medium mb-2">Avatar</label>
                        <div class="flex items-center">
                            @if($user->avatar)
                                <div class="mr-4">
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full object-cover border border-gray-200">
                                </div>
                            @endif
                            <div class="flex-1">
                                <input type="file" name="avatar" id="avatar" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent">
                                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, GIF (Maks. 2MB)</p>
                            </div>
                        </div>
                        @error('avatar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="address" class="block text-gray-700 font-medium mb-2">Alamat</label>
                        <textarea name="address" id="address" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" rows="3">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="city" class="block text-gray-700 font-medium mb-2">Kota</label>
                        <input type="text" name="city" id="city" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" value="{{ old('city', $user->city) }}">
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="province" class="block text-gray-700 font-medium mb-2">Provinsi</label>
                        <input type="text" name="province" id="province" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" value="{{ old('province', $user->province) }}">
                        @error('province')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="postal_code" class="block text-gray-700 font-medium mb-2">Kode Pos</label>
                        <input type="text" name="postal_code" id="postal_code" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" value="{{ old('postal_code', $user->postal_code) }}">
                        @error('postal_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="map-admin" class="block text-gray-700 font-medium mb-2">Lokasi di Peta</label>
                        <div id="map-admin" class="w-full h-64 rounded-lg border border-gray-300 mb-2"></div>
                        <p class="mt-1 text-xs text-gray-500">Klik pada peta untuk menandai lokasi</p>
                        <div class="grid grid-cols-2 gap-4 mt-2">
                            <div>
                                <label for="latitude" class="block text-gray-700 font-medium mb-1">Latitude</label>
                                <input type="text" name="latitude" id="latitude" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" value="{{ old('latitude', $user->latitude) }}">
                            </div>
                            <div>
                                <label for="longitude" class="block text-gray-700 font-medium mb-1">Longitude</label>
                                <input type="text" name="longitude" id="longitude" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" value="{{ old('longitude', $user->longitude) }}">
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label for="is_default_address" class="flex items-center">
                            <input type="checkbox" name="is_default_address" id="is_default_address" class="rounded border-gray-300 text-green-600 focus:ring-green-600" {{ old('is_default_address', $user->is_default_address) ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700 font-medium">Jadikan Alamat Default</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-6 mt-6 flex items-center justify-end">
                <button type="button" onclick="window.history.back()" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2.5 px-5 rounded-lg transition-colors shadow-sm mr-3">
                    Batal
                </button>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 px-5 rounded-lg transition-colors shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    // Wait for the document to fully load
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Admin document loaded, initializing map');

        // Default coordinates (Jakarta or user's saved location)
        const defaultLat = {{ $user->latitude ?? -6.2088 }};
        const defaultLng = {{ $user->longitude ?? 106.8456 }};
        console.log('Admin map using coordinates:', defaultLat, defaultLng);

        // Set the initial values in the visible fields
        document.getElementById('latitude').value = defaultLat;
        document.getElementById('longitude').value = defaultLng;

        let map, marker;

        // Wait a moment before initializing the map to ensure container is ready
        setTimeout(() => {
            try {
                console.log('Creating admin map in map-admin element');

                // Initialize the map
                map = L.map('map-admin').setView([defaultLat, defaultLng], 15);

                // Add the tile layer (OpenStreetMap)
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Add marker at the default position
                marker = L.marker([defaultLat, defaultLng], {
                    draggable: true,
                    title: "Lokasi Pelanggan"
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

                console.log('Admin map initialized successfully');
            } catch (error) {
                console.error('Error initializing admin map:', error);
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
            console.log('Getting address for admin map:', lat, lng);

            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`, {
                headers: {
                    'Accept-Language': 'id',
                    'User-Agent': 'TokoDeden Admin Application'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Admin Nominatim response:', data);

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

                    console.log('Admin address fields updated');
                }
            })
            .catch(error => {
                console.error('Error getting address for admin:', error);
            });
        }
    });
</script>
@endpush
@endsection
