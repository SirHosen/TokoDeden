<x-app-layout>
    <!-- Hero Section -->
    <section class="relative bg-cover bg-center py-20" style="background-image: url('https://images.unsplash.com/photo-1500595046743-cd271d694d30?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2070&q=80');">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="container mx-auto px-4 z-10 relative text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Toko Pakan Ternak Online Terlengkap</h1>
            <p class="text-xl text-white mb-8">Jual berbagai jenis pakan ternak berkualitas dengan harga terbaik</p>
            <a href="{{ route('shop.products.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg inline-block transition duration-300">Belanja Sekarang</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Mengapa Memilih Toko Deden?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6 border border-gray-100 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-truck-fast text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Pengiriman Cepat</h3>
                    <p class="text-gray-600">Gratis ongkir untuk pembelian dalam radius 2km dan pengiriman cepat ke lokasi Anda.</p>
                </div>
                <div class="text-center p-6 border border-gray-100 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-medal text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Kualitas Terbaik</h3>
                    <p class="text-gray-600">Produk pakan ternak berkualitas tinggi yang menjamin kesehatan dan pertumbuhan ternak.</p>
                </div>
                <div class="text-center p-6 border border-gray-100 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Layanan Pelanggan</h3>
                    <p class="text-gray-600">Dukungan pelanggan responsif dan siap membantu untuk semua kebutuhan Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Produk Unggulan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredProducts as $product)
                    <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition duration-300">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full uppercase font-semibold tracking-wide">{{ $product->category->name }}</span>
                            <h3 class="text-lg font-semibold mt-2">{{ $product->name }}</h3>
                            <p class="text-gray-500 text-sm mt-1">{{ Str::limit($product->description, 60) }}</p>
                            <div class="flex items-center justify-between mt-4">
                                <span class="text-lg font-bold text-green-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <a href="{{ route('shop.products.show', $product->slug) }}" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm transition duration-300">Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-10">
                <a href="{{ route('shop.products.index') }}" class="inline-block border-2 border-green-600 text-green-600 hover:bg-green-600 hover:text-white font-semibold py-2 px-6 rounded-lg transition duration-300">Lihat Semua Produk</a>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Kategori Produk</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach($categories as $category)
                    <a href="{{ route('shop.products.index', ['category' => $category->slug]) }}" class="bg-gray-50 hover:bg-green-50 border border-gray-200 rounded-lg p-4 text-center transition duration-300">
                        <span class="block text-lg font-medium text-gray-800">{{ $category->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Apa Kata Pelanggan Kami</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">"Pakan ternak dari Toko Deden sangat berkualitas. Ternak ayam saya tumbuh sehat dan cepat besar. Pengiriman juga cepat dan tepat waktu."</p>
                    <div class="font-medium">Budi Santoso</div>
                    <div class="text-sm text-gray-500">Peternak Ayam</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">"Saya sangat puas dengan layanan Toko Deden. Produknya lengkap dan harganya sangat kompetitif. Saya sudah langganan lebih dari 2 tahun."</p>
                    <div class="font-medium">Siti Rahmawati</div>
                    <div class="text-sm text-gray-500">Peternak Kambing</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">"Website-nya mudah digunakan dan proses pemesanan sangat cepat. Pengiriman gratis untuk area dekat toko juga sangat membantu."</p>
                    <div class="font-medium">Ahmad Hidayat</div>
                    <div class="text-sm text-gray-500">Peternak Sapi</div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
