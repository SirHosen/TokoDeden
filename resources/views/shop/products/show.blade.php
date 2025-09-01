<x-app-layout>
    <!-- Product Detail Hero -->
    <div class="bg-gradient-to-r from-green-700 to-green-800 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex mb-3" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="/" class="text-green-100 hover:text-white">
                            <i class="fas fa-home mr-1"></i> Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-green-200 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="{{ route('shop.products.index') }}" class="ml-1 text-green-100 hover:text-white">Produk</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-green-200 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="{{ route('shop.products.index', ['category' => $product->category->slug]) }}" class="ml-1 text-green-100 hover:text-white">{{ $product->category->name }}</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-green-200 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-white font-medium truncate max-w-xs">{{ $product->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                    <!-- Product Image -->
                    <div class="bg-gray-50 rounded-xl overflow-hidden border border-gray-100">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-[500px] object-contain p-8">
                        @else
                            <div class="w-full h-[500px] flex items-center justify-center bg-gradient-to-r from-green-50 to-green-100 p-8">
                                <div class="text-center">
                                    <i class="fas fa-seedling text-7xl mb-5 text-green-600"></i>
                                    <p class="text-lg font-medium text-green-800">{{ $product->category->name }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Product Details -->
                    <div class="flex flex-col py-4">
                        <div class="mb-8">
                            <div class="flex items-center mb-4">
                                <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full uppercase font-semibold tracking-wide">{{ $product->category->name }}</span>
                                @if($product->stock > 0)
                                    <span class="ml-3 bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full uppercase font-semibold tracking-wide">Tersedia</span>
                                @else
                                    <span class="ml-3 bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full uppercase font-semibold tracking-wide">Stok Habis</span>
                                @endif
                            </div>

                            <h1 class="text-3xl font-bold text-gray-900 mb-3">{{ $product->name }}</h1>
                            <p class="text-2xl font-bold text-yellow-500 mb-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                            <div class="flex items-center mt-3 text-gray-500">
                                <i class="fas fa-box-open mr-2"></i>
                                <span>Stok: {{ $product->stock }} unit</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 my-6 pt-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Deskripsi Produk</h3>
                            <div class="text-gray-700 space-y-4 mb-6">
                                <p class="leading-relaxed">{{ $product->description }}</p>
                            </div>

                            <div class="bg-green-50 border-l-4 border-green-600 p-4 rounded-r-lg mt-6">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-leaf text-green-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-green-800">Kualitas Terjamin</h3>
                                        <div class="mt-2 text-sm text-green-700">
                                            <p>Produk ini telah melalui pemeriksaan kualitas dan terjamin keamanannya.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($product->stock > 0)
                            <div class="mt-auto">
                                <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div>
                                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                                        <div class="flex">
                                            <div class="relative flex items-center max-w-[8rem]">
                                                <button type="button" id="decrement-button"
                                                    class="bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-l-lg p-3 h-11 focus:ring-gray-100 focus:outline-none"
                                                    onclick="decrementQuantity()">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input
                                                    type="number"
                                                    name="quantity"
                                                    id="quantity"
                                                    min="1"
                                                    max="{{ $product->stock }}"
                                                    value="1"
                                                    class="bg-gray-50 border-x-0 border-gray-300 h-11 text-center text-gray-900 text-sm focus:ring-0 block w-full py-2.5"
                                                    required
                                                >
                                                <button type="button" id="increment-button"
                                                    class="bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-r-lg p-3 h-11 focus:ring-gray-100 focus:outline-none"
                                                    onclick="incrementQuantity({{ $product->stock }})">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                            <button
                                                type="submit"
                                                class="bg-green-600 hover:bg-green-700 text-white font-medium px-8 py-2 ml-4 rounded-lg transition-all duration-300 flex-grow shadow-sm hover:shadow flex items-center justify-center"
                                            >
                                                <i class="fas fa-shopping-cart mr-2"></i> Tambah ke Keranjang
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="mt-auto">
                                <div class="bg-red-50 border-l-4 border-red-600 p-4 rounded-r-lg">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-exclamation-circle text-red-600"></i>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-red-800">Stok Habis</h3>
                                            <div class="mt-2 text-sm text-red-700">
                                                <p>Mohon maaf, stok produk ini sedang habis. Silahkan kembali lagi nanti.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <script>
                function decrementQuantity() {
                    const input = document.getElementById('quantity');
                    if(input.value > 1) {
                        input.value = parseInt(input.value) - 1;
                    }
                }

                function incrementQuantity(max) {
                    const input = document.getElementById('quantity');
                    if(parseInt(input.value) < max) {
                        input.value = parseInt(input.value) + 1;
                    }
                }
            </script>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="mt-16">
                    <div class="text-center mb-10">
                        <h2 class="text-3xl font-extrabold text-gray-900">Produk Terkait</h2>
                        <div class="w-24 h-1 bg-green-600 mx-auto mt-4 rounded-full"></div>
                        <p class="mt-4 text-gray-600">Produk lain dalam kategori yang sama</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $related)
                            <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 group hover:-translate-y-1">
                                <div class="relative">
                                    @if($related->image)
                                        <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="w-full h-56 object-cover">
                                    @else
                                        <div class="bg-gradient-to-r from-green-50 to-green-100 w-full h-56 flex items-center justify-center">
                                            <div class="text-center">
                                                <i class="fas fa-seedling text-5xl mb-3 text-green-600"></i>
                                                <p class="text-sm font-medium text-green-800">{{ $related->category->name }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="absolute top-3 left-3">
                                        <span class="bg-green-600 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $related->category->name }}</span>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-green-700 transition-colors">{{ $related->name }}</h3>
                                    <p class="text-gray-600 text-sm mt-2 line-clamp-2">{{ $related->description }}</p>
                                    <div class="flex items-center justify-between mt-6">
                                        <span class="text-lg font-bold text-yellow-500">Rp {{ number_format($related->price, 0, ',', '.') }}</span>
                                        <a href="{{ route('shop.products.show', $related->slug) }}"
                                           class="inline-flex items-center text-green-700 font-medium hover:text-green-800">
                                            Detail <i class="fas fa-arrow-right ml-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Product Benefits -->
            <div class="mt-16 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-3">
                    <div class="p-8 text-center border-b md:border-b-0 md:border-r border-gray-100">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 mb-4">
                            <i class="fas fa-truck text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Pengiriman Cepat</h3>
                        <p class="text-gray-600">Produk dikirim langsung dari gudang kami ke lokasi Anda</p>
                    </div>

                    <div class="p-8 text-center border-b md:border-b-0 md:border-r border-gray-100">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 mb-4">
                            <i class="fas fa-certificate text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Kualitas Terjamin</h3>
                        <p class="text-gray-600">Semua produk kami melewati quality control yang ketat</p>
                    </div>

                    <div class="p-8 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 mb-4">
                            <i class="fas fa-headset text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Layanan Pelanggan</h3>
                        <p class="text-gray-600">Tim kami siap membantu Anda dengan segala pertanyaan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
