@extends('layouts.admin')

@section('header', 'Detail Pengguna')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-gray-600 hover:text-green-600 transition-colors">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Pengguna
    </a>
</div>

<div class="bg-white shadow-lg rounded-xl overflow-hidden mb-6">
    <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4 flex justify-between items-center">
        <h3 class="text-white font-semibold text-lg">Informasi Pengguna</h3>
        <div class="flex space-x-2">
            <a href="{{ route('admin.users.edit', $user) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-1 px-3 rounded-lg text-sm transition-colors shadow-sm">
                <i class="fas fa-edit mr-1"></i> Edit
            </a>
            <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline-block">
                @csrf
                @method('PATCH')
                <button type="submit" class="{{ $user->is_active ? 'bg-orange-600 hover:bg-orange-700' : 'bg-green-600 hover:bg-green-700' }} text-white py-1 px-3 rounded-lg text-sm transition-colors shadow-sm" onclick="return confirm('Apakah Anda yakin ingin {{ $user->is_active ? 'menonaktifkan' : 'mengaktifkan' }} pengguna ini?')">
                    <i class="fas {{ $user->is_active ? 'fa-ban' : 'fa-check-circle' }} mr-1"></i> {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
            </form>
        </div>
    </div>

    <div class="p-6">
        <div class="flex flex-col md:flex-row md:items-start">
            <div class="flex-shrink-0 mb-6 md:mb-0 md:mr-8 text-center md:text-left">
                <div class="relative inline-block">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-32 h-32 rounded-full object-cover border-4 border-gray-200 shadow">
                    @else
                        <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center border-4 border-gray-200 shadow">
                            <i class="fas fa-user text-gray-400 text-4xl"></i>
                        </div>
                    @endif
                    <span class="absolute bottom-1 right-1 w-6 h-6 rounded-full {{ $user->is_active ? 'bg-green-500' : 'bg-red-500' }} border-2 border-white"></span>
                </div>
                <div class="mt-4 text-center">
                    <span class="px-3 py-1 rounded-full {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} text-xs font-medium">
                        {{ $user->is_active ? 'Akun Aktif' : 'Akun Tidak Aktif' }}
                    </span>
                </div>
            </div>

            <div class="flex-grow grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="mb-5">
                        <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $user->name }}</h3>
                        <p class="text-gray-500 text-sm">{{ $user->role->name }}</p>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Email</p>
                            <p class="text-gray-800">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nomor Telepon</p>
                            <p class="text-gray-800">{{ $user->phone ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tanggal Registrasi</p>
                            <p class="text-gray-800">{{ $user->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="mb-3">
                        <h4 class="font-semibold text-gray-700">Informasi Alamat</h4>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Alamat Lengkap</p>
                            <p class="text-gray-800">{{ $user->address ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Kota</p>
                            <p class="text-gray-800">{{ $user->city ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Provinsi</p>
                            <p class="text-gray-800">{{ $user->province ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Kode Pos</p>
                            <p class="text-gray-800">{{ $user->postal_code ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order History -->
<div class="bg-white shadow-lg rounded-xl overflow-hidden">
    <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4">
        <h3 class="text-white font-semibold text-lg">Riwayat Pesanan</h3>
    </div>
    <div class="p-6">
        @if($user->orders->count() > 0)
            <div class="overflow-x-auto bg-white rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No. Pesanan
                            </th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($user->orders->sortByDesc('created_at') as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $order->order_number }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $order->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status == 'shipped') bg-indigo-100 text-indigo-800
                                        @elseif($order->status == 'delivered') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-6 text-gray-500">
                <div class="text-5xl text-gray-300 mb-3">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <p>Pengguna ini belum memiliki pesanan.</p>
            </div>
        @endif
    </div>
</div>
@endsection
