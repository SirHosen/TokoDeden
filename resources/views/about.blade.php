<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-12">
                <div class="md:flex">
                    <div class="md:w-1/2">
                        <img src="https://images.unsplash.com/photo-1516467508483-a7212febe31a?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2070&q=80" alt="About Toko Deden" class="w-full h-full object-cover">
                    </div>
                    <div class="md:w-1/2 p-8 md:p-12 flex items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800 mb-4">Tentang Toko Deden</h1>
                            <p class="text-gray-600 mb-6">
                                Toko Deden adalah toko pakan ternak online terpercaya yang berdedikasi menyediakan berbagai jenis pakan ternak berkualitas dengan harga kompetitif. Kami melayani kebutuhan peternak di seluruh wilayah dengan pengiriman cepat dan pelayanan terbaik.
                            </p>
                            <p class="text-gray-600">
                                Didirikan pada tahun 2015, Toko Deden telah menjadi mitra terpercaya bagi banyak peternak untuk memenuhi kebutuhan pakan ternak mereka. Kami berkomitmen untuk selalu menyediakan produk berkualitas tinggi dan pelayanan yang memuaskan untuk semua pelanggan kami.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Our Values -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Nilai-Nilai Kami</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-hand-holding-heart text-2xl text-green-600"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-3">Pelayanan Terbaik</h3>
                        <p class="text-gray-600">Kami berkomitmen untuk memberikan pelayanan terbaik dengan respon cepat dan solusi yang tepat untuk kebutuhan pelanggan.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-award text-2xl text-green-600"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-3">Kualitas Terjamin</h3>
                        <p class="text-gray-600">Setiap produk yang kami jual telah melalui proses seleksi ketat untuk memastikan kualitas terbaik untuk ternak Anda.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-truck-fast text-2xl text-green-600"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-3">Pengiriman Cepat</h3>
                        <p class="text-gray-600">Kami menjamin pengiriman cepat dan aman ke lokasi Anda dengan biaya yang terjangkau.</p>
                    </div>
                </div>
            </div>

            <!-- Our Team -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Tim Kami</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Deden Supratman" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
                        <h3 class="text-lg font-semibold">Deden Supratman</h3>
                        <p class="text-gray-600">Pendiri & CEO</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Siti Nurhaliza" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
                        <h3 class="text-lg font-semibold">Siti Nurhaliza</h3>
                        <p class="text-gray-600">Manajer Operasional</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                        <img src="https://randomuser.me/api/portraits/men/55.jpg" alt="Budi Santoso" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
                        <h3 class="text-lg font-semibold">Budi Santoso</h3>
                        <p class="text-gray-600">Ahli Nutrisi Ternak</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                        <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Dewi Lestari" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
                        <h3 class="text-lg font-semibold">Dewi Lestari</h3>
                        <p class="text-gray-600">Layanan Pelanggan</p>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="bg-green-600 rounded-lg shadow-sm p-8 text-center">
                <h2 class="text-2xl font-bold text-white mb-4">Siap untuk Memulai?</h2>
                <p class="text-white mb-6 max-w-2xl mx-auto">
                    Jelajahi koleksi lengkap produk pakan ternak berkualitas kami untuk memenuhi kebutuhan ternak Anda.
                </p>
                <a href="{{ route('shop.products.index') }}" class="inline-block bg-white text-green-600 hover:bg-gray-100 font-bold py-3 px-8 rounded-lg transition duration-300">
                    Belanja Sekarang
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
