@extends('layouts.admin')

@section('header', 'Laporan Penjualan')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800">Laporan Penjualan</h2>
    <p class="text-gray-600 text-sm">Analisis kinerja penjualan dan pendapatan</p>
</div>

<!-- Date Filter -->
<div class="bg-white shadow-sm rounded-lg mb-6 p-6">
    <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-col sm:flex-row items-center">
        <div class="mb-4 sm:mb-0 sm:mr-4 w-full sm:w-auto">
            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
            <input type="date" id="start_date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent">
        </div>
        <div class="mb-4 sm:mb-0 sm:mr-4 w-full sm:w-auto">
            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
            <input type="date" id="end_date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent">
        </div>
        <div class="mt-4 sm:mt-6 w-full sm:w-auto">
            <button type="submit" class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg">
                Terapkan Filter
            </button>
        </div>
    </form>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
    <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center">
            <div class="bg-green-100 rounded-full p-3">
                <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-700">Total Penjualan</h3>
                <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center">
            <div class="bg-blue-100 rounded-full p-3">
                <i class="fas fa-shopping-bag text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-700">Jumlah Pesanan</h3>
                <p class="text-2xl font-bold text-gray-800">{{ $totalOrders }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center">
            <div class="bg-purple-100 rounded-full p-3">
                <i class="fas fa-receipt text-purple-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-700">Rata-rata Pesanan</h3>
                <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Sales Chart -->
    <div class="bg-white shadow-sm rounded-lg p-6 lg:col-span-2">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Grafik Penjualan Harian</h3>
        <div class="h-80">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Export Button and Product Performance -->
    <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Ekspor Laporan</h3>
            <a href="{{ route('admin.reports.export', ['start_date' => $startDate->format('Y-m-d'), 'end_date' => $endDate->format('Y-m-d')]) }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg inline-block w-full text-center">
                <i class="fas fa-download mr-2"></i> Unduh Laporan CSV
            </a>
        </div>

        <h3 class="text-lg font-semibold text-gray-800 mb-3">Produk Terlaris</h3>
        @if($productSales->isEmpty())
            <p class="text-gray-500 text-sm">Tidak ada data penjualan produk dalam periode ini.</p>
        @else
            <div class="space-y-4">
                @foreach($productSales->take(5) as $product)
                    <div class="border-b border-gray-200 pb-3 last:border-0">
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-gray-800">{{ $product->name }}</span>
                            <span class="text-sm text-gray-600">{{ $product->total_quantity }} terjual</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ min(100, ($product->total_revenue / $totalSales) * 100) }}%"></div>
                        </div>
                        <div class="text-sm text-right mt-1 text-gray-600">
                            Rp {{ number_format($product->total_revenue, 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Pendapatan Harian',
                    data: {!! json_encode($chartData) !!},
                    backgroundColor: 'rgba(34, 197, 94, 0.2)',
                    borderColor: 'rgba(34, 197, 94, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    pointBackgroundColor: 'rgba(34, 197, 94, 1)',
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += 'Rp ' + context.parsed.y.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection
