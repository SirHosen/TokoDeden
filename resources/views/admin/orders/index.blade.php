@extends('layouts.admin')

@section('header', 'Manajemen Pesanan')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Kelola semua pesanan dari pelanggan</h2>
</div>

<div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">
    <div class="p-4 border-b border-gray-200">
        <div class="flex flex-wrap items-center">
            <span class="mr-4 text-sm font-medium text-gray-700">Filter Status:</span>
            <a href="{{ route('admin.orders.index') }}" class="px-3 py-1 mb-2 mr-2 text-sm rounded-full {{ !request('status') ? 'bg-green-100 text-green-800' : 'bg-gray-100 hover:bg-gray-200' }}">
                Semua
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="px-3 py-1 mb-2 mr-2 text-sm rounded-full {{ request('status') == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 hover:bg-gray-200' }}">
                Menunggu Konfirmasi
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="px-3 py-1 mb-2 mr-2 text-sm rounded-full {{ request('status') == 'processing' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 hover:bg-gray-200' }}">
                Sedang Diproses
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}" class="px-3 py-1 mb-2 mr-2 text-sm rounded-full {{ request('status') == 'shipped' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 hover:bg-gray-200' }}">
                Dalam Pengiriman
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" class="px-3 py-1 mb-2 mr-2 text-sm rounded-full {{ request('status') == 'delivered' ? 'bg-green-100 text-green-800' : 'bg-gray-100 hover:bg-gray-200' }}">
                Diterima
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" class="px-3 py-1 mb-2 mr-2 text-sm rounded-full {{ request('status') == 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 hover:bg-gray-200' }}">
                Dibatalkan
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'rejected']) }}" class="px-3 py-1 mb-2 mr-2 text-sm rounded-full {{ request('status') == 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 hover:bg-gray-200' }}">
                Ditolak
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        No. Pesanan
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Pelanggan
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tanggal
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Total
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Detail
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($orders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $order->order_number }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $order->created_at->format('d M Y') }}</div>
                            <div class="text-sm text-gray-500">{{ $order->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-800">
                                {{ $order->status_name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-green-600 hover:text-green-800">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada pesanan yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4">
        {{ $orders->appends(request()->except('page'))->links() }}
    </div>
</div>
@endsection
