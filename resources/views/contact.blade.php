<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Hubungi Kami</h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Contact Info -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-semibold mb-4">Informasi Kontak</h2>

                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="bg-green-100 rounded-full p-3 mr-4">
                                    <i class="fas fa-map-marker-alt text-green-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Alamat</h3>
                                    <p class="text-gray-600 mt-1">Jl. Peternakan No. 123, Jakarta Timur, DKI Jakarta 13750</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="bg-green-100 rounded-full p-3 mr-4">
                                    <i class="fas fa-phone text-green-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Telepon</h3>
                                    <p class="text-gray-600 mt-1">(021) 1234-5678</p>
                                    <p class="text-gray-600">0812-3456-7890</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="bg-green-100 rounded-full p-3 mr-4">
                                    <i class="fas fa-envelope text-green-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Email</h3>
                                    <p class="text-gray-600 mt-1">info@tokodeden.com</p>
                                    <p class="text-gray-600">cs@tokodeden.com</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="bg-green-100 rounded-full p-3 mr-4">
                                    <i class="fas fa-clock text-green-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Jam Operasional</h3>
                                    <p class="text-gray-600 mt-1">Senin - Jumat: 08.00 - 17.00</p>
                                    <p class="text-gray-600">Sabtu: 08.00 - 15.00</p>
                                    <p class="text-gray-600">Minggu: Tutup</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <h3 class="font-medium text-gray-800 mb-3">Ikuti Kami</h3>
                            <div class="flex space-x-4">
                                <a href="#" class="bg-green-100 hover:bg-green-200 text-green-600 w-10 h-10 rounded-full flex items-center justify-center">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="bg-green-100 hover:bg-green-200 text-green-600 w-10 h-10 rounded-full flex items-center justify-center">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="bg-green-100 hover:bg-green-200 text-green-600 w-10 h-10 rounded-full flex items-center justify-center">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="bg-green-100 hover:bg-green-200 text-green-600 w-10 h-10 rounded-full flex items-center justify-center">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form and Map -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Contact Form -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-semibold mb-4">Kirim Pesan</h2>

                        <form action="#" method="POST" class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="text" id="name" name="name" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" required>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" id="email" name="email" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" required>
                            </div>

                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subjek</label>
                                <input type="text" id="subject" name="subject" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" required>
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                                <textarea id="message" name="message" rows="5" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" required></textarea>
                            </div>

                            <div>
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg">
                                    Kirim Pesan
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Map -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-semibold mb-4">Lokasi Kami</h2>
                        <div id="map" class="w-full h-80 rounded-lg border"></div>
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
        document.addEventListener('DOMContentLoaded', function() {
            const map = L.map('map').setView([-6.175110, 106.865039], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Add marker for store location
            L.marker([-6.175110, 106.865039]).addTo(map)
                .bindPopup("<b>Toko Deden</b><br>Toko Pakan Ternak")
                .openPopup();
        });
    </script>
    @endpush
</x-app-layout>
