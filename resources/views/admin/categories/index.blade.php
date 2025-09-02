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
        <div class="overflow-x-auto bg-white rounded-lg border border-gray-200">
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
                            Slug
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
                        <tr>
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
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $category->slug }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $category->products_count }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
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
</div>

<!-- Category Statistics -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
            <h3 class="text-white font-semibold text-lg">Kategori Teratas</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($categories->sortByDesc('products_count')->take(5) as $category)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-100">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0">
                            @if($category->image)
                                <img class="h-10 w-10 object-cover"
                                     src="{{ asset('storage/' . $category->image) }}"
                                     alt="{{ $category->name }}">
                            @else
                                <div class="w-full h-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                                    {{ strtoupper(substr($category->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="ml-3">
                            <div class="font-medium text-gray-800">{{ $category->name }}</div>
                            <div class="text-xs text-gray-500">{{ $category->slug }}</div>
                        </div>
                    </div>
                    <div class="bg-indigo-100 text-indigo-800 text-sm py-1 px-3 rounded-full font-medium">
                        {{ $category->products_count }} Produk
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-gray-500">
                    Belum ada data kategori
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-cyan-600 px-6 py-4">
            <h3 class="text-white font-semibold text-lg">Ringkasan Kategori</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 gap-6">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 p-5 rounded-xl">
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-3">
                            <i class="fas fa-layer-group text-blue-600 text-xl"></i>
                        </div>
                        <p class="text-gray-600 text-sm mb-1">Total Kategori</p>
                        <h4 class="text-3xl font-bold text-blue-800">{{ $categories->count() }}</h4>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 p-5 rounded-xl">
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mb-3">
                            <i class="fas fa-box-open text-purple-600 text-xl"></i>
                        </div>
                        <p class="text-gray-600 text-sm mb-1">Rata-rata Produk</p>
                        <h4 class="text-3xl font-bold text-purple-800">
                            {{ $categories->count() > 0 ? round($categories->sum('products_count') / $categories->count()) : 0 }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="mt-6 bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 p-5 rounded-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Kategori Tanpa Produk</p>
                        <h4 class="text-xl font-bold text-gray-800">{{ $categories->where('products_count', 0)->count() }}</h4>
                    </div>
                    <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        <i class="fas fa-arrow-right"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
