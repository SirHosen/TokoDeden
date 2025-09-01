@extends('layouts.admin')

@section('header', 'Edit Kategori')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.categories.index') }}" class="text-green-600 hover:text-green-800">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Kategori
    </a>
</div>

<div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-6">Edit Kategori: {{ $category->name }}</h2>

        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent @error('name') border-red-500 @enderror" value="{{ old('name', $category->name) }}" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg">
                    Perbarui Kategori
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
