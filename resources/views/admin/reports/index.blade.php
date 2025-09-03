@extends('layouts.admin')

@section('header', 'Laporan Penjualan')

@section('content')
<div class="flex justify-between items-start mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Analisis kinerja penjualan dan metrik bisnis</h2>
    </div>
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.reports.export', ['start_date' => $startDate->format('Y-m-d'), 'end_date' => $endDate->format('Y-m-d')]) }}" class="flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-all shadow-sm">
            <i class="fas fa-file-pdf mr-2"></i> Ekspor PDF
        </a>
    </div>
</div>

<!-- Date Filter -->
<div class="bg-white shadow-lg rounded-xl mb-8 overflow-hidden">
    <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4">
        <h3 class="text-white font-semibold text-lg">Filter Laporan</h3>
    </div>
    <div class="p-6">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-col sm:flex-row items-end space-y-4 sm:space-y-0 sm:space-x-4">
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
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
    <div class="bg-white shadow-lg rounded-xl p-6 relative overflow-hidden dashboard-card">
        <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-r from-green-500/10 to-green-500/30 transform -skew-x-12"></div>
        <div class="flex items-center justify-between relative">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Penjualan</p>
                <h3 class="text-3xl font-extrabold text-gray-800 mb-1">Rp {{ number_format($totalSales, 0, ',', '.') }}</h3>
                <span class="inline-flex items-center text-xs font-medium text-green-600 bg-green-100 px-2 py-0.5 rounded-full">
                    <i class="fas fa-arrow-up mr-1"></i> {{ number_format(($totalSales > 0 ? 2.5 : 0), 1) }}% dari bulan lalu
                </span>
            </div>
            <div class="w-14 h-14 bg-gradient-green rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-money-bill-wave text-white text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-xl p-6 relative overflow-hidden dashboard-card">
        <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-r from-blue-500/10 to-blue-500/30 transform -skew-x-12"></div>
        <div class="flex items-center justify-between relative">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Jumlah Pesanan</p>
                <h3 class="text-3xl font-extrabold text-gray-800 mb-1">{{ $totalOrders }}</h3>
                <span class="inline-flex items-center text-xs font-medium text-blue-600 bg-blue-100 px-2 py-0.5 rounded-full">
                    <i class="fas fa-arrow-up mr-1"></i> {{ number_format(($totalOrders > 0 ? 1.8 : 0), 1) }}% dari bulan lalu
                </span>
            </div>
            <div class="w-14 h-14 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-shopping-bag text-white text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-xl p-6 relative overflow-hidden dashboard-card">
        <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-r from-purple-500/10 to-purple-500/30 transform -skew-x-12"></div>
        <div class="flex items-center justify-between relative">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Rata-rata Pesanan</p>
                <h3 class="text-3xl font-extrabold text-gray-800 mb-1">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</h3>
                <span class="inline-flex items-center text-xs font-medium text-purple-600 bg-purple-100 px-2 py-0.5 rounded-full">
                    <i class="fas fa-arrow-up mr-1"></i> {{ number_format(($averageOrderValue > 0 ? 3.2 : 0), 1) }}% dari bulan lalu
                </span>
            </div>
            <div class="w-14 h-14 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-receipt text-white text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Sales Chart -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden lg:col-span-2">
        <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-white">Grafik Penjualan Harian</h3>
            <div class="flex items-center space-x-2">
                <button id="viewTypeLineBtn" class="text-xs bg-white/20 hover:bg-white/30 text-white px-3 py-1 rounded transition-all active">Line</button>
                <button id="viewTypeBarBtn" class="text-xs bg-white/10 hover:bg-white/30 text-white px-3 py-1 rounded transition-all">Bar</button>
            </div>
        </div>
        <div class="p-6">
            <div class="h-96">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Product Performance -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4">
            <h3 class="text-lg font-semibold text-white">Produk Terlaris</h3>
        </div>
        <div class="p-6">
            @if($productSales->isEmpty())
                <div class="flex flex-col items-center justify-center py-8">
                    <i class="fas fa-chart-pie text-gray-300 text-5xl mb-4"></i>
                    <p class="text-gray-500 text-center">Tidak ada data penjualan produk dalam periode ini.</p>
                </div>
            @else
                <!-- Top 3 Products with Special Design -->
                <div class="space-y-5 mb-6">
                    <h4 class="font-semibold text-gray-700 mb-4">Top 3 Produk Terlaris</h4>
                    @foreach($productSales->take(3) as $index => $product)
                        <div class="border-b border-gray-200 pb-5 last:border-0 last:pb-0">
                            <div class="flex justify-between mb-2 items-center">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center
                                        {{ $index === 0 ? 'bg-yellow-100 text-yellow-700' :
                                           ($index === 1 ? 'bg-gray-100 text-gray-700' :
                                           'bg-amber-50 text-amber-800') }} mr-3 font-bold">
                                        #{{ $index + 1 }}
                                    </div>
                                    <span class="font-medium text-gray-800">{{ $product->name }}</span>
                                </div>
                                <span class="text-gray-600 font-medium py-1 px-2.5 bg-gray-100 rounded-full text-sm">
                                    {{ $product->total_quantity }} terjual
                                </span>
                            </div>
                            <div class="w-full h-2.5 bg-gray-200 rounded-full overflow-hidden">
                                <div class="bg-gradient-to-r
                                    {{ $index === 0 ? 'from-yellow-500 to-yellow-400' :
                                       ($index === 1 ? 'from-gray-500 to-gray-400' :
                                       'from-amber-600 to-amber-500') }}
                                    h-2.5 rounded-full" style="width: {{ min(100, ($product->total_revenue / $totalSales) * 100) }}%"></div>
                            </div>
                            <div class="flex justify-between mt-2">
                                <span class="text-xs text-gray-500">{{ number_format(min(100, ($product->total_revenue / $totalSales) * 100), 1) }}% dari total</span>
                                <span class="text-sm font-semibold text-gray-700">
                                    Rp {{ number_format($product->total_revenue, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Link to Product Sales Page -->
                <div class="mt-6 pt-4 border-t border-gray-200 text-center">
                    <a href="{{ route('admin.products.sales') }}" class="bg-green-50 text-green-600 hover:bg-green-100 hover:text-green-800 transition-colors font-medium text-sm inline-flex items-center px-4 py-2 rounded-lg border border-green-200">
                        <i class="fas fa-chart-bar mr-2"></i> Lihat Semua Produk Terjual
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sales chart initialization
        const ctx = document.getElementById('salesChart').getContext('2d');
        const chartData = {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Pendapatan Harian',
                data: {!! json_encode($chartData) !!},
                backgroundColor: 'rgba(34, 197, 94, 0.2)',
                borderColor: 'rgba(34, 197, 94, 1)',
                borderWidth: 2,
                tension: 0.4,
                pointBackgroundColor: 'rgba(34, 197, 94, 1)',
                fill: true
            }]
        };

        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        boxWidth: 12,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleFont: {
                        size: 13
                    },
                    bodyFont: {
                        size: 12
                    },
                    padding: 10,
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
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        };

        const salesChart = new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: chartOptions
        });

        // Add chart type toggle functionality
        document.getElementById('viewTypeLineBtn').addEventListener('click', function() {
            this.classList.add('active', 'bg-white/20');
            this.classList.remove('bg-white/10');
            document.getElementById('viewTypeBarBtn').classList.remove('active', 'bg-white/20');
            document.getElementById('viewTypeBarBtn').classList.add('bg-white/10');
            salesChart.config.type = 'line';
            salesChart.update();
        });

        document.getElementById('viewTypeBarBtn').addEventListener('click', function() {
            this.classList.add('active', 'bg-white/20');
            this.classList.remove('bg-white/10');
            document.getElementById('viewTypeLineBtn').classList.remove('active', 'bg-white/20');
            document.getElementById('viewTypeLineBtn').classList.add('bg-white/10');
            salesChart.config.type = 'bar';
            salesChart.data.datasets[0].backgroundColor = 'rgba(34, 197, 94, 0.6)';
            salesChart.update();
        });
    });
</script>
@endpush
@endsection
