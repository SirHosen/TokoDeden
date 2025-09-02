<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-12">
                <div class="md:flex">
                    <div class="md:w-1/2">
                        <img src="https://images.unsplash.com/photo-1681705357021-d5434018247b?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="About Toko Deden" class="w-full h-full object-cover">
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

            <!-- CTA -->
            <div class="relative rounded-2xl shadow-xl overflow-hidden text-center">
    <!-- Background image -->
    <div class="absolute inset-0">
        <img src="https://media.istockphoto.com/id/521602228/id/foto/pakan-ternak.jpg?s=612x612&w=0&k=20&c=7QCh_BjkLhiXgORgX45yyEgV9lQePahNNgmyfxe5j-U="
             alt="Background Pakan Ternak"
             class="w-full h-full object-cover">
        <!-- Overlay gradient -->
        <div class="absolute inset-0 bg-gradient-to-r from-green-700/80 to-emerald-600/70"></div>
    </div>

    <!-- Content -->
    <div class="relative p-12">
        <h2 class="text-4xl font-extrabold text-white mb-4 drop-shadow-lg">
            Siap untuk Memulai?
        </h2>
        <p class="text-white/95 mb-8 max-w-2xl mx-auto leading-relaxed drop-shadow">
            Jelajahi koleksi lengkap produk pakan ternak berkualitas kami untuk memenuhi kebutuhan ternak Anda.
        </p>
        <a href="{{ route('shop.products.index') }}"
           class="inline-flex items-center gap-2 bg-white text-green-700 font-semibold py-3 px-10 rounded-xl shadow-md transform transition duration-300 hover:scale-105 hover:shadow-xl">
            Belanja Sekarang
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>
</div>


        </div>
    </div>
</x-app-layout>
