@extends('layouts.admin')

@section('header', 'Tambah Pengguna Baru')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-gray-600 hover:text-green-600 transition-colors">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Pengguna
    </a>
</div>

<div class="bg-white shadow-lg rounded-xl overflow-hidden">
    <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4">
        <h3 class="text-white font-semibold text-lg">Tambah Pengguna Baru</h3>
    </div>
    <div class="p-6">
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-semibold text-gray-700 mb-4">Informasi Dasar</h4>

                    <div class="mb-5">
                        <label for="name" class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" value="{{ old('name') }}" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                        <input type="email" name="email" id="email" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" value="{{ old('email') }}" required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="phone" class="block text-gray-700 font-medium mb-2">Nomor Telepon</label>
                        <input type="text" name="phone" id="phone" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" value="{{ old('phone') }}">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <input type="hidden" name="role_id" value="{{ App\Models\Role::where('name', 'customer')->first()->id }}">

                    <div class="mb-5">
                        <label for="is_active" class="flex items-center">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" id="is_active" value="1" class="rounded border-gray-300 text-green-600 focus:ring-green-600" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700 font-medium">Akun Aktif</span>
                        </label>
                        @error('is_active')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="password" class="block text-gray-700 font-medium mb-2">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" id="password" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" required minlength="8" placeholder="Minimal 8 karakter">
                        <div class="mt-1 text-xs text-gray-500">
                            <span id="password-length" class="text-gray-400">0 karakter</span>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" required minlength="8" placeholder="Ulangi password">
                        <div class="mt-1 text-xs text-gray-500">
                            <span id="password-match" class="text-gray-400">Password belum diisi</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-700 mb-4">Informasi Lainnya</h4>

                    <div class="mb-5">
                        <label for="avatar" class="block text-gray-700 font-medium mb-2">Avatar</label>
                        <input type="file" name="avatar" id="avatar" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent">
                        <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, GIF (Maks. 2MB)</p>
                        @error('avatar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="address" class="block text-gray-700 font-medium mb-2">Alamat</label>
                        <textarea name="address" id="address" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" rows="3">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="city" class="block text-gray-700 font-medium mb-2">Kota</label>
                        <input type="text" name="city" id="city" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" value="{{ old('city') }}">
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="province" class="block text-gray-700 font-medium mb-2">Provinsi</label>
                        <input type="text" name="province" id="province" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" value="{{ old('province') }}">
                        @error('province')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="postal_code" class="block text-gray-700 font-medium mb-2">Kode Pos</label>
                        <input type="text" name="postal_code" id="postal_code" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" value="{{ old('postal_code') }}">
                        @error('postal_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-6 mt-6 flex items-center justify-end">
                <button type="button" onclick="window.history.back()" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2.5 px-5 rounded-lg transition-colors shadow-sm mr-3">
                    Batal
                </button>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 px-5 rounded-lg transition-colors shadow-sm">
                    Tambah Pengguna
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const passwordLength = document.getElementById('password-length');
    const passwordMatch = document.getElementById('password-match');

    // Monitor password length
    passwordInput.addEventListener('input', function() {
        const length = this.value.length;
        passwordLength.textContent = length + ' karakter';

        if (length >= 8) {
            passwordLength.className = 'text-green-600';
        } else {
            passwordLength.className = 'text-red-500';
        }

        checkPasswordMatch();
    });

    // Monitor password confirmation
    passwordConfirmInput.addEventListener('input', function() {
        checkPasswordMatch();
    });

    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirmation = passwordConfirmInput.value;

        if (password === '' || confirmation === '') {
            passwordMatch.textContent = 'Password belum diisi';
            passwordMatch.className = 'text-gray-400';
        } else if (password === confirmation) {
            passwordMatch.textContent = 'Password cocok';
            passwordMatch.className = 'text-green-600';
        } else {
            passwordMatch.textContent = 'Password tidak cocok';
            passwordMatch.className = 'text-red-500';
        }
    }
});
</script>
@endpush
@endsection
