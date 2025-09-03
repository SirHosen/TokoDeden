@extends('layouts.admin')

@section('header', 'Edit Profil')

@section('content')
<div class="bg-white shadow-lg rounded-xl overflow-hidden">
    <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4">
        <h3 class="text-white font-semibold text-lg">Edit Profil Saya</h3>
    </div>
    <div class="p-6">
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-semibold text-gray-700 mb-4">Informasi Dasar</h4>

                    <div class="mb-5">
                        <label for="name" class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                        <input type="email" name="email" id="email" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="phone" class="block text-gray-700 font-medium mb-2">Nomor Telepon</label>
                        <input type="text" name="phone" id="phone" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" value="{{ old('phone', $user->phone) }}">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="password" class="block text-gray-700 font-medium mb-2">Password Baru (kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" id="password" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent">
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-700 mb-4">Foto Profil</h4>

                    <div class="mb-5">
                        <div class="flex flex-col items-center">
                            @if($user->avatar)
                                <div class="mb-4">
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-32 h-32 rounded-full object-cover border-4 border-gray-200">
                                </div>
                            @else
                                <div class="mb-4 w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center border-4 border-gray-300">
                                    <span class="text-gray-500 text-4xl font-semibold">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="flex-1 w-full">
                                <input type="file" name="avatar" id="avatar" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent">
                                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, GIF (Maks. 2MB)</p>
                            </div>
                        </div>
                        @error('avatar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <h4 class="font-semibold text-gray-700 mb-4 mt-8">Informasi Admin</h4>

                    <div class="bg-gray-100 rounded-lg p-4">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 rounded-full bg-green-600 flex items-center justify-center text-white">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="ml-3">
                                <p class="font-medium text-gray-800">{{ $user->role->name }}</p>
                                <p class="text-xs text-gray-500">Role Admin</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">Sebagai admin, Anda memiliki akses penuh ke Dashboard Admin dan semua fitur manajemen.</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-6 mt-6 flex items-center justify-end">
                <button type="button" onclick="window.history.back()" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2.5 px-5 rounded-lg transition-colors shadow-sm mr-3">
                    Batal
                </button>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 px-5 rounded-lg transition-colors shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
