<x-app-layout>
    <!-- Hero Section with Header -->
    <div class="relative bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1569466593977-94ee7ed02ec9?q=80&w=1332&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); height: 85vh;">
        <!-- Overlay with gradient -->
        <div class="absolute inset-0 bg-gradient-to-r from-green-900/70 to-black/70"></div>

        <!-- Hero Content -->
        <div class="relative z-10 flex items-center justify-center h-full px-4">
            <div class="text-center max-w-4xl">
                <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 leading-tight">Pakan Ternak <span class="text-yellow-400">Berkualitas</span> Untuk Ternak Anda</h1>
                <p class="text-xl md:text-2xl text-white mb-10 max-w-3xl mx-auto">Temukan berbagai jenis pakan ternak premium dengan harga terbaik untuk hasil ternak yang optimal</p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-6 justify-center">
                    <a href="{{ route('shop.products.index') }}" class="px-8 py-4 bg-yellow-500 text-gray-900 font-bold rounded-lg hover:bg-yellow-400 transition duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-shopping-cart mr-2"></i> Belanja Sekarang
                    </a>
                    <a href="{{ route('about') }}" class="px-8 py-4 bg-white/10 backdrop-filter backdrop-blur-sm border-2 border-white/30 text-white font-medium rounded-lg hover:bg-white/20 transition duration-300">
                        <i class="fas fa-info-circle mr-2"></i> Tentang Kami
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Preview Section -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Mengapa Memilih Kami?</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">Kami menyediakan produk pakan ternak terbaik dengan layanan pengiriman cepat dan dukungan pelanggan 24/7</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="bg-gradient-to-br from-green-50 to-green-100 p-8 rounded-xl border border-green-200 shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                    <div class="bg-green-600 rounded-full w-16 h-16 flex items-center justify-center mb-6 mx-auto">
                        <i class="fas fa-truck-fast text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 text-center">Pengiriman Cepat</h3>
                    <p class="text-gray-600 text-center">Gratis ongkir untuk area dalam radius 2km dan pengiriman cepat ke lokasi Anda dalam waktu singkat.</p>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-green-100 p-8 rounded-xl border border-green-200 shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                    <div class="bg-green-600 rounded-full w-16 h-16 flex items-center justify-center mb-6 mx-auto">
                        <i class="fas fa-medal text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 text-center">Kualitas Premium</h3>
                    <p class="text-gray-600 text-center">Produk pakan ternak berkualitas tinggi dengan nutrisi lengkap untuk pertumbuhan optimal ternak Anda.</p>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-green-100 p-8 rounded-xl border border-green-200 shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                    <div class="bg-green-600 rounded-full w-16 h-16 flex items-center justify-center mb-6 mx-auto">
                        <i class="fas fa-headset text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 text-center">Layanan Pelanggan</h3>
                    <p class="text-gray-600 text-center">Dukungan pelanggan responsif dan profesional siap membantu untuk semua kebutuhan Anda.</p>
                </div>
            </div>
        </div>
    </div>    <!-- Featured Products Section -->
    <div class="bg-gray-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 uppercase rounded-full">Pilihan Terbaik</span>
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl mt-3">Produk Unggulan Kami</h2>
                <div class="w-24 h-1 bg-yellow-500 mx-auto mt-5 rounded-full"></div>
                <p class="mt-5 text-lg text-gray-600 max-w-3xl mx-auto">Pakan ternak berkualitas untuk hasil ternak yang optimal</p>
            </div>

            @if($featuredProducts->isEmpty())
                <div class="bg-white rounded-xl p-10 shadow-sm text-center max-w-2xl mx-auto">
                    <i class="fas fa-box-open text-5xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-700">Belum Ada Produk</h3>
                    <p class="text-gray-500 mt-2">Kami sedang menambahkan produk-produk berkualitas. Silakan periksa kembali nanti.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($featuredProducts as $product)
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm group hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
                            <div class="relative">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-56 object-cover">
                                @else
                                    <div class="bg-gradient-to-r from-green-50 to-green-100 w-full h-56 flex items-center justify-center">
                                        <div class="text-center">
                                            <i class="fas fa-seedling text-5xl mb-3 text-green-600"></i>
                                            <p class="text-sm font-medium text-green-800">{{ $product->category->name }}</p>
                                        </div>
                                    </div>
                                @endif
                                <div class="absolute top-3 left-3">
                                    <span class="bg-green-600 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $product->category->name }}</span>
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="font-bold text-lg mb-2 text-gray-900 group-hover:text-green-700">{{ $product->name }}</h3>
                                <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $product->description }}</p>
                                <div class="flex items-center justify-between mt-4">
                                    <p class="text-yellow-500 font-bold text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <a href="{{ route('shop.products.show', $product->slug) }}"
                                        class="inline-flex items-center text-green-700 font-medium hover:text-green-800">
                                        Detail <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-14">
                    <a href="{{ route('shop.products.index') }}" class="inline-flex items-center px-6 py-3 bg-green-700 hover:bg-green-800 text-white font-medium rounded-lg transition-all duration-300 shadow-md hover:shadow-lg">
                        Lihat Semua Produk <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-green-700 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="md:w-2/3 text-center md:text-left mb-8 md:mb-0">
                    <h2 class="text-3xl font-bold text-white">Siap untuk meningkatkan kualitas ternak Anda?</h2>
                    <p class="text-green-100 mt-3 text-lg">Hubungi kami sekarang dan dapatkan penawaran khusus untuk pembelian pertama Anda!</p>
                </div>
                <div>
                    <a href="{{ route('shop.products.index') }}" class="inline-block bg-white text-green-700 font-bold py-3 px-8 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1 hover:bg-yellow-50">
                        Belanja Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
