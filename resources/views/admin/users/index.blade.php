@extends('layouts.admin')

@section('header', 'Manajemen Pengguna')

@section('content')
<div class="flex justify-between items-start mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Kelola semua pengguna terdaftar</h2>
    </div>
    <a href="{{ route('admin.users.create') }}" class="flex items-center bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium py-2.5 px-5 rounded-lg transition-all shadow-md hover:shadow-lg">
        <i class="fas fa-user-plus mr-2"></i> Tambah Pengguna
    </a>
</div>

<!-- Search and Filter -->
<div class="bg-white shadow-lg rounded-xl overflow-hidden mb-6">
    <div class="p-6">
        <form action="{{ route('admin.users.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" name="search" placeholder="Cari pengguna..."
                    class="block w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-600 focus:border-transparent"
                    value="{{ request('search') }}">
            </div>
            <div>
                <select name="status" class="block w-full py-2.5 px-4 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-600 focus:border-transparent">
                    <option value="">-- Filter Status --</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg shadow-sm flex-grow md:flex-grow-0 flex items-center justify-center">
                    <i class="fas fa-filter mr-2"></i> Terapkan Filter
                </button>
                <a href="{{ route('admin.users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2.5 rounded-lg shadow-sm flex-grow md:flex-grow-0 flex items-center justify-center">
                    <i class="fas fa-redo-alt mr-2"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
    <div class="bg-white shadow-lg rounded-xl p-6 relative overflow-hidden">
        <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-r from-blue-500/10 to-blue-500/30 transform -skew-x-12"></div>
        <div class="flex items-center justify-between relative">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Pengguna</p>
                <h3 class="text-3xl font-extrabold text-gray-800 mb-1">{{ $totalUsers }}</h3>
                <span class="text-xs font-medium text-gray-500">Customer terdaftar</span>
            </div>
            <div class="w-14 h-14 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-users text-white text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-xl p-6 relative overflow-hidden">
        <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-r from-green-500/10 to-green-500/30 transform -skew-x-12"></div>
        <div class="flex items-center justify-between relative">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Pengguna Aktif</p>
                <h3 class="text-3xl font-extrabold text-gray-800 mb-1">{{ $activeUsers }}</h3>
                <span class="text-xs font-medium text-gray-500">Dapat melakukan transaksi</span>
            </div>
            <div class="w-14 h-14 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-user-check text-white text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-xl p-6 relative overflow-hidden">
        <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-r from-red-500/10 to-red-500/30 transform -skew-x-12"></div>
        <div class="flex items-center justify-between relative">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Pengguna Tidak Aktif</p>
                <h3 class="text-3xl font-extrabold text-gray-800 mb-1">{{ $inactiveUsers }}</h3>
                <span class="text-xs font-medium text-gray-500">Terbatas akses sistem</span>
            </div>
            <div class="w-14 h-14 bg-gradient-to-r from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-user-slash text-white text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="bg-white shadow-lg rounded-xl overflow-hidden">
    <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4">
        <h3 class="text-white font-semibold text-lg">Daftar Pengguna</h3>
    </div>
    <div class="p-6">
        <div class="overflow-x-auto bg-white rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pengguna
                        </th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kontak
                        </th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Alamat
                        </th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Registrasi
                        </th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($user->avatar)
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-user text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $user->role->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                <div class="text-xs text-gray-500">{{ $user->phone ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $user->address ?? '-' }}</div>
                                @if($user->city || $user->province)
                                    <div class="text-xs text-gray-500">
                                        {{ $user->city ?? '' }}{{ $user->city && $user->province ? ', ' : '' }}{{ $user->province ?? '' }}
                                        {{ $user->postal_code ? '- ' . $user->postal_code : '' }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-3">
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="{{ $user->is_active ? 'text-orange-600 hover:text-orange-900' : 'text-green-600 hover:text-green-900' }}" onclick="return confirm('Apakah Anda yakin ingin {{ $user->is_active ? 'menonaktifkan' : 'mengaktifkan' }} pengguna ini?')">
                                            <i class="fas {{ $user->is_active ? 'fa-ban' : 'fa-check-circle' }}"></i> {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada pengguna yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $users->withQueryString()->links('components.admin-pagination') }}
        </div>
    </div>
</div>
@endsection
