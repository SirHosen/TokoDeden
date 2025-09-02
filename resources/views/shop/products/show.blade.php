<x-app-layout>
    <!-- Product Detail Hero -->
    <div class="bg-gradient-to-r from-green-700 to-green-800 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex mb-3" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="/" class="text-green-100 hover:text-white transition">
                            <i class="fas fa-home mr-1"></i> Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-green-200 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="{{ route('shop.products.index') }}" class="ml-1 text-green-100 hover:text-white transition">Produk</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-green-200 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="{{ route('shop.products.index', ['category' => $product->category->slug]) }}" class="ml-1 text-green-100 hover:text-white transition">
                                <div class="flex items-center">
                                    @if($product->category->image)
                                        <img src="{{ asset('storage/' . $product->category->image) }}" class="w-4 h-4 rounded-full mr-1 bg-white" alt="{{ $product->category->name }}">
                                    @endif
                                    {{ $product->category->name }}
                                </div>
                            </a>
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
            <h1 class="text-3xl md:text-4xl font-bold text-white mt-4">{{ $product->name }}</h1>
        </div>
    </div>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-0 md:gap-8">
                    <!-- Product Image -->
                    <div class="md:rounded-l-xl overflow-hidden md:border-r border-gray-100 bg-white md:bg-gray-50">
                        <div class="relative">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-[500px] object-contain p-4 md:p-8">
                                <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-gray-50/80 to-transparent pointer-events-none"></div>
                            @else
                                <div class="w-full h-[500px] flex items-center justify-center bg-gradient-to-r from-green-50 to-green-100 p-8">
                                    <div class="text-center">
                                        <i class="fas fa-seedling text-7xl mb-5 text-green-600"></i>
                                        <p class="text-lg font-medium text-green-800">{{ $product->category->name }}</p>
                                    </div>
                                </div>
                            @endif

                            <div class="absolute top-4 left-4">
                                <div class="flex items-center">
                                    @if($product->category->image)
                                        <div class="h-8 w-8 rounded-full overflow-hidden mr-2 border-2 border-white shadow-md">
                                            <img src="{{ asset('storage/' . $product->category->image) }}"
                                                 class="w-full h-full object-cover"
                                                 alt="{{ $product->category->name }}">
                                        </div>
                                    @endif
                                    <span class="bg-green-600/80 backdrop-blur-sm text-white text-xs px-3 py-1.5 rounded-full font-medium shadow-md">
                                        {{ $product->category->name }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="flex flex-col p-6 md:p-8">
                        <div class="mb-6">
                            <div class="flex items-center mb-4">
                                <div class="flex items-center">
                                    @if($product->stock > 0)
                                        <span class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white text-xs px-3 py-1.5 rounded-full uppercase font-semibold tracking-wide shadow-sm flex items-center">
                                            <i class="fas fa-check-circle mr-1"></i> Tersedia
                                        </span>
                                    @else
                                        <span class="bg-gradient-to-r from-red-500 to-red-600 text-white text-xs px-3 py-1.5 rounded-full uppercase font-semibold tracking-wide shadow-sm flex items-center">
                                            <i class="fas fa-times-circle mr-1"></i> Stok Habis
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <p class="text-3xl font-bold text-yellow-500 mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                            <div class="flex items-center justify-between mt-4 bg-gray-50 p-3 rounded-lg">
                                <div class="flex items-center text-gray-700">
                                    <i class="fas fa-box-open text-green-600 mr-2"></i>
                                    <span>Stok: <span class="font-medium">{{ $product->stock }} unit</span></span>
                                </div>
                                <div class="flex items-center text-gray-700">
                                    <i class="fas fa-truck text-green-600 mr-2"></i>
                                    <span>Siap Kirim</span>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 my-6 pt-6">
                            <div class="flex items-center mb-4">
                                <h3 class="text-xl font-bold text-gray-900">Deskripsi Produk</h3>
                                <div class="ml-auto">
                                    <button class="text-green-600 hover:text-green-800 flex items-center text-sm" onclick="toggleDescription()">
                                        <span id="toggleText">Selengkapnya</span>
                                        <i class="fas fa-chevron-down ml-1" id="toggleIcon"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="text-gray-700 space-y-4 mb-6 description-container overflow-hidden transition-all duration-300" id="productDescription" style="max-height: 80px;">
                                <p class="leading-relaxed">{{ $product->description }}</p>
                            </div>
                        </div>

                        @if($product->stock > 0)
                            <div class="mt-auto">
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                                    <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 shadow-sm">
                                        <div class="flex items-center justify-between mb-4">
                                            <label for="quantity" class="text-base font-medium text-gray-700">Jumlah</label>
                                            <span class="text-sm text-gray-500">Tersedia: {{ $product->stock }} unit</span>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <div class="relative flex items-center max-w-[8rem]">
                                                <button type="button"
                                                    class="bg-green-600 hover:bg-green-700 text-white border-0 rounded-l-lg p-3 h-12 focus:outline-none transition-all"
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
                                                    class="bg-white border border-gray-300 h-12 text-center text-gray-900 text-base focus:ring-0 block w-full py-2.5"
                                                    required
                                                >
                                                <button type="button"
                                                    class="bg-green-600 hover:bg-green-700 text-white border-0 rounded-r-lg p-3 h-12 focus:outline-none transition-all"
                                                    onclick="incrementQuantity({{ $product->stock }})">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>

                                            <button
                                                type="submit"
                                                class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium px-8 py-3 rounded-lg transition-all duration-300 flex-grow shadow-md hover:shadow-lg flex items-center justify-center"
                                            >
                                                <i class="fas fa-shopping-cart mr-2"></i> Tambah ke Keranjang
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="mt-auto">
                                <div class="bg-red-50 rounded-xl border border-red-200 p-6 shadow-sm">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <div class="h-12 w-12 rounded-full bg-red-100 flex items-center justify-center">
                                                <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-medium text-red-800">Stok Habis</h3>
                                            <div class="mt-2 text-base text-red-700">
                                                <p>Mohon maaf, stok produk ini sedang habis. Silahkan kembali lagi nanti.</p>
                                            </div>
                                            <div class="mt-4">
                                                <a href="{{ route('shop.products.index') }}" class="inline-flex items-center justify-center px-5 py-2 border border-transparent text-base font-medium rounded-lg text-white bg-red-600 hover:bg-red-700">
                                                    <i class="fas fa-arrow-left mr-2"></i> Lihat Produk Lainnya
                                                </a>
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

                function toggleDescription() {
                    const description = document.getElementById('productDescription');
                    const toggleText = document.getElementById('toggleText');
                    const toggleIcon = document.getElementById('toggleIcon');

                    if (description.style.maxHeight === '80px') {
                        description.style.maxHeight = '1000px';
                        toggleText.innerText = 'Sembunyikan';
                        toggleIcon.classList.remove('fa-chevron-down');
                        toggleIcon.classList.add('fa-chevron-up');
                    } else {
                        description.style.maxHeight = '80px';
                        toggleText.innerText = 'Selengkapnya';
                        toggleIcon.classList.remove('fa-chevron-up');
                        toggleIcon.classList.add('fa-chevron-down');
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

            <!-- End of Related Products -->
        </div>
    </div>
</x-app-layout>
