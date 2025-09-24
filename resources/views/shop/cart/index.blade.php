<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-6">Keranjang Belanja</h1>

            @if($cartItems->isEmpty())
                <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                    <i class="fas fa-shopping-cart text-5xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-700">Keranjang Anda kosong</h3>
                    <p class="text-gray-500 mt-2">Tambahkan beberapa produk ke keranjang Anda untuk melanjutkan belanja.</p>
                    <a href="{{ route('shop.products.index') }}" class="inline-block mt-4 px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">
                        Belanja Sekarang
                    </a>
                </div>
            @else
                <div class="flex flex-col lg:flex-row gap-6">
                    <!-- Cart Items -->
                    <div class="lg:w-2/3">
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Produk
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Harga
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jumlah
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Subtotal
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($cartItems as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-16 w-16">
                                                        @if($item->product->image && file_exists(public_path('storage/' . $item->product->image)))
                                                            <img class="h-16 w-16 object-cover rounded" src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                                                        @else
                                                            <div class="h-16 w-16 bg-gray-200 rounded flex items-center justify-center">
                                                                <i class="fas fa-image text-gray-400 text-xl"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $item->product->name }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center space-x-1">
                                                    <!-- Tombol Minus -->
                                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="quantity" value="{{ max(1, $item->quantity - 1) }}">
                                                        <button type="submit" class="w-8 h-8 rounded border border-gray-300 bg-gray-100 hover:bg-gray-200 disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed flex items-center justify-center text-gray-600 hover:text-gray-800 transition-colors text-sm font-medium" {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                            -
                                                        </button>
                                                    </form>

                                                    <!-- Input Jumlah -->
                                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="number" name="quantity" id="quantity-{{ $item->id }}" min="1" max="{{ $item->product->stock }}" value="{{ $item->quantity }}" class="w-16 text-center py-1 px-1 border border-gray-300 rounded focus:ring-1 focus:ring-green-500 focus:border-green-500" style="-webkit-appearance: none; -moz-appearance: textfield;" onchange="this.form.submit()">
                                                    </form>

                                                    <!-- Tombol Plus -->
                                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="quantity" value="{{ min($item->product->stock, $item->quantity + 1) }}">
                                                        <button type="submit" class="w-8 h-8 rounded border border-gray-300 bg-gray-100 hover:bg-gray-200 disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed flex items-center justify-center text-gray-600 hover:text-gray-800 transition-colors text-sm font-medium" {{ $item->quantity >= $item->product->stock ? 'disabled' : '' }}>
                                                            +
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Cart Summary -->
                    <div class="lg:w-1/3">
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h3 class="text-lg font-semibold mb-4">Ringkasan Belanja</h3>
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between mb-2 text-gray-500 text-sm">
                                    <span>Ongkos Kirim</span>
                                    <span>Dihitung saat checkout</span>
                                </div>
                                <div class="border-t border-gray-200 mt-4 pt-4">
                                    <div class="flex justify-between">
                                        <span class="text-lg font-semibold">Total</span>
                                        <span class="text-lg font-bold text-green-600">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <a href="{{ route('checkout.index') }}" class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition duration-300 flex items-center justify-center">
                                        Lanjutkan ke Checkout
                                    </a>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('shop.products.index') }}" class="w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-50 transition duration-300 flex items-center justify-center">
                                        Lanjutkan Belanja
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>


    <style>
        /* Hide number input spinners */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
</x-app-layout>
