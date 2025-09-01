<x-app-layout>
    <!-- Hero Banner -->
    <div class="bg-gradient-to-r from-green-700 to-green-900 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center justify-center text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4">Katalog Produk</h1>
                <p class="text-xl text-green-100 max-w-2xl">Temukan pakan berkualitas untuk ternak Anda</p>

                @if(request('category'))
                    @php
                        $currentCategory = $categories->where('slug', request('category'))->first();
                    @endphp
                    @if($currentCategory)
                        <div class="mt-6 inline-flex bg-white bg-opacity-20 backdrop-blur-sm rounded-full px-4 py-2">
                            <span class="text-white">Kategori: <span class="font-semibold">{{ $currentCategory->name }}</span></span>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar/Filters -->
                <div class="w-full lg:w-1/4">
                    <div class="bg-white p-8 rounded-xl shadow-sm mb-6 sticky top-24">
                        <h3 class="text-xl font-bold mb-6 text-gray-900">Kategori</h3>
                        <div class="border-b border-gray-100 mb-6"></div>
                        <ul class="space-y-3">
                            <li>
                                <a href="{{ route('shop.products.index') }}"
                                   class="flex items-center group {{ !request('category') ? 'font-semibold text-green-700' : 'text-gray-700' }}">
                                    <span class="w-2 h-2 rounded-full {{ !request('category') ? 'bg-green-700' : 'bg-gray-300 group-hover:bg-green-700' }} mr-3 transition-all duration-300"></span>
                                    Semua Kategori
                                </a>
                            </li>
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('shop.products.index', ['category' => $category->slug]) }}"
                                       class="flex items-center group {{ request('category') == $category->slug ? 'font-semibold text-green-700' : 'text-gray-700' }}">
                                        <span class="w-2 h-2 rounded-full {{ request('category') == $category->slug ? 'bg-green-700' : 'bg-gray-300 group-hover:bg-green-700' }} mr-3 transition-all duration-300"></span>
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <h3 class="text-xl font-bold mb-6 text-gray-900 mt-10">Filter</h3>
                        <div class="border-b border-gray-100 mb-6"></div>

                        <form action="{{ route('shop.products.index') }}" method="GET">
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif

                            <div class="mb-6">
                                <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">Urutkan Berdasarkan</label>
                                <select
                                    name="sort"
                                    id="sort"
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent bg-white"
                                    onchange="this.form.submit()"
                                >
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                                        Terbaru
                                    </option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>
                                        Harga: Rendah ke Tinggi
                                    </option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>
                                        Harga: Tinggi ke Rendah
                                    </option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Products -->
                <div class="w-full lg:w-3/4">
                    <!-- Search -->
                    <div class="bg-white p-6 rounded-xl shadow-sm mb-8">
                        <form action="{{ route('shop.products.index') }}" method="GET">
                            <div class="relative">
                                @if(request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                @if(request('sort'))
                                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                                @endif
                                <input
                                    type="text"
                                    name="search"
                                    placeholder="Cari produk..."
                                    class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent text-gray-700"
                                    value="{{ request('search') }}"
                                >
                                <div class="absolute left-4 top-3.5 text-gray-400">
                                    <i class="fas fa-search"></i>
                                </div>
                                <button type="submit" class="absolute right-3 top-2.5 bg-green-600 text-white px-3 py-1 rounded-md hover:bg-green-700 transition-colors">
                                    Cari
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Results Summary -->
                    <div class="flex items-center justify-between mb-6">
                        <p class="text-gray-600">
                            Menampilkan <span class="font-semibold">{{ $products->count() }}</span> dari <span class="font-semibold">{{ $products->total() }}</span> produk
                        </p>

                        @if(request('search') || request('category'))
                            <a href="{{ route('shop.products.index') }}" class="text-green-600 hover:text-green-800 flex items-center">
                                <i class="fas fa-times-circle mr-1"></i> Reset Filter
                            </a>
                        @endif
                    </div>

                    <!-- Product Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($products as $product)
                            <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 group hover:-translate-y-1">
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
                                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-green-700 transition-colors">{{ $product->name }}</h3>
                                    <p class="text-gray-600 text-sm mt-2 line-clamp-2">{{ $product->description }}</p>
                                    <div class="flex items-center justify-between mt-6">
                                        <span class="text-lg font-bold text-yellow-500">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <a href="{{ route('shop.products.show', $product->slug) }}"
                                           class="inline-flex items-center text-green-700 font-medium hover:text-green-800">
                                            Detail <i class="fas fa-arrow-right ml-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 bg-white p-12 rounded-xl shadow-sm text-center">
                                <img src="https://cdn-icons-png.flaticon.com/512/1178/1178479.png" alt="No results" class="w-24 h-24 mx-auto opacity-30 mb-6">
                                <h3 class="text-2xl font-bold text-gray-700 mb-3">Produk tidak ditemukan</h3>
                                <p class="text-gray-500 mb-8 max-w-md mx-auto">Coba cari dengan kata kunci lain atau reset filter untuk melihat semua produk.</p>
                                <a href="{{ route('shop.products.index') }}"
                                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors shadow-sm">
                                    <i class="fas fa-th-large mr-2"></i> Lihat Semua Produk
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12">
                        {{ $products->appends(request()->except('page'))->links() }}
                    </div>

                    <!-- Need Help Section -->
                    <div class="mt-16 bg-gradient-to-r from-green-50 to-green-100 rounded-xl p-8 border border-green-200">
                        <div class="flex flex-col md:flex-row items-center">
                            <div class="md:w-1/4 text-center mb-6 md:mb-0">
                                <div class="w-20 h-20 bg-green-600 rounded-full mx-auto flex items-center justify-center text-white">
                                    <i class="fas fa-headset text-3xl"></i>
                                </div>
                            </div>
                            <div class="md:w-3/4 md:pl-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Butuh bantuan untuk menemukan produk yang tepat?</h3>
                                <p class="text-gray-600 mb-4">Tim kami siap membantu Anda menemukan pakan terbaik sesuai kebutuhan ternak Anda. Konsultasikan kebutuhan Anda dengan kami.</p>
                                <a href="{{ route('contact') }}" class="inline-flex items-center px-5 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition-all">
                                    <i class="fas fa-phone-alt mr-2"></i> Hubungi Kami
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
