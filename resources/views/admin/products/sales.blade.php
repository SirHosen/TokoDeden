@extends('layouts.admin')

@section('header', 'Laporan Penjualan Produk')

@section('content')
<div class="flex justify-between items-start mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Detail Penjualan Semua Produk</h2>
        <p class="text-gray-600 mt-1">Melihat performa semua produk yang terjual</p>
    </div>
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.reports.index') }}" class="flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-all shadow-sm">
            <i class="fas fa-chart-line mr-2"></i> Kembali ke Laporan
        </a>
    </div>
</div>

<!-- Date Filter -->
<div class="bg-white shadow-lg rounded-xl mb-8 overflow-hidden">
    <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4">
        <h3 class="text-white font-semibold text-lg">Filter Tanggal</h3>
    </div>
    <div class="p-6">
        <form action="{{ route('admin.products.sales') }}" method="GET" class="flex flex-col sm:flex-row items-end space-y-4 sm:space-y-0 sm:space-x-4">
            <div class="w-full sm:w-1/3">
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" id="start_date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-500 shadow-sm">
            </div>
            <div class="w-full sm:w-1/3">
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                <input type="date" id="end_date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-500 shadow-sm">
            </div>
            <div class="w-full sm:w-1/3">
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 px-6 rounded-lg transition-colors shadow-sm">
                    <i class="fas fa-filter mr-2"></i> Terapkan Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
    <div class="bg-white shadow-lg rounded-xl p-6 relative overflow-hidden">
        <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-r from-green-500/10 to-green-500/30 transform -skew-x-12"></div>
        <div class="flex items-center justify-between relative">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Produk Terjual</p>
                <h3 class="text-3xl font-extrabold text-gray-800 mb-1">{{ $totalSold }} item</h3>
                <span class="text-sm font-medium text-gray-500">Periode {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</span>
            </div>
            <div class="w-14 h-14 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-box text-white text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-xl p-6 relative overflow-hidden">
        <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-r from-blue-500/10 to-blue-500/30 transform -skew-x-12"></div>
        <div class="flex items-center justify-between relative">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Pendapatan</p>
                <h3 class="text-3xl font-extrabold text-gray-800 mb-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                <span class="text-sm font-medium text-gray-500">Periode {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</span>
            </div>
            <div class="w-14 h-14 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-money-bill-wave text-white text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Product Sales Table -->
<div class="bg-white shadow-lg rounded-xl overflow-hidden">
    <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-white">Daftar Penjualan Produk</h3>
    </div>
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50">
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Satuan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Terjual</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pendapatan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pesanan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok Tersisa</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($productSales as $index => $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ ($productSales->currentPage() - 1) * $productSales->perPage() + $index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/default-product.png') }}" alt="{{ $product->name }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-medium">{{ $product->total_quantity ?: 0 }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                Rp {{ number_format($product->total_revenue ?: 0, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $product->order_count ?: 0 }} pesanan
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $product->stock }} tersisa
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                Tidak ada data penjualan produk dalam periode ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $productSales->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
