@extends('layouts.admin')

@section('header', 'Manajemen Kategori')

@section('content')
<div class="flex justify-between items-start mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Kelola dan atur kategori produk Anda</h2>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="flex items-center bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium py-2.5 px-5 rounded-lg transition-all shadow-md hover:shadow-lg">
        <i class="fas fa-plus-circle mr-2"></i> Tambah Kategori
    </a>
</div>

<div class="bg-white shadow-lg rounded-xl overflow-hidden">
    <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4">
        <h3 class="text-white font-semibold text-lg">Daftar Kategori</h3>
    </div>
    <div class="p-6">
        <!-- Tabel Kategori -->
        <div class="overflow-x-auto bg-white rounded-lg border border-gray-200 shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Logo
                        </th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama Kategori
                        </th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jumlah Produk
                        </th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($category->image)
                                        <img class="h-10 w-10 rounded-full object-cover border border-gray-200"
                                             src="{{ asset('storage/' . $category->image) }}"
                                             alt="{{ $category->name }}">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                                            {{ strtoupper(substr($category->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                                <div class="text-xs text-gray-500">{{ $category->slug }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded-full">
                                    {{ $category->products_count }} produk
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-3">
                                    <a href="{{ route('admin.products.index', ['category' => $category->id]) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i> Lihat Produk
                                    </a>
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-900">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada kategori yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Informasi Kategori Ringkas -->
    <div class="p-4 border-t border-gray-200">
        <div class="flex flex-wrap justify-between items-center gap-4">
            <div class="bg-blue-50 px-4 py-2 rounded-lg border border-blue-100">
                <span class="text-sm text-gray-600">Total Kategori:</span>
                <span class="ml-2 font-bold text-blue-700">{{ $categories->count() }}</span>
            </div>
            <div class="bg-purple-50 px-4 py-2 rounded-lg border border-purple-100">
                <span class="text-sm text-gray-600">Total Produk dalam Kategori:</span>
                <span class="ml-2 font-bold text-purple-700">{{ $categories->sum('products_count') }}</span>
            </div>
            <div class="bg-amber-50 px-4 py-2 rounded-lg border border-amber-100">
                <span class="text-sm text-gray-600">Kategori Tanpa Produk:</span>
                <span class="ml-2 font-bold text-amber-700">{{ $categories->where('products_count', 0)->count() }}</span>
            </div>
        </div>
    </div>
</div>

@endsection
