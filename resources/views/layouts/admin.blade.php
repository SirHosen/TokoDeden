<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Toko Deden') }} - Admin Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Styles -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white min-h-screen flex flex-col" x-data="{ open: false }">
            <div class="p-5 border-b border-gray-700">
                <a href="{{ route('admin.dashboard') }}">
                    <h1 class="text-xl font-bold">Admin Panel</h1>
                </a>
            </div>
            <div class="flex-1 overflow-y-auto py-4 px-3">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }} flex items-center p-2 text-base font-normal text-white rounded-lg hover:bg-gray-700">
                            <i class="fas fa-tachometer-alt w-6"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'bg-gray-700' : '' }} flex items-center p-2 text-base font-normal text-white rounded-lg hover:bg-gray-700">
                            <i class="fas fa-box w-6"></i>
                            <span>Produk</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'bg-gray-700' : '' }} flex items-center p-2 text-base font-normal text-white rounded-lg hover:bg-gray-700">
                            <i class="fas fa-tags w-6"></i>
                            <span>Kategori</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'bg-gray-700' : '' }} flex items-center p-2 text-base font-normal text-white rounded-lg hover:bg-gray-700">
                            <i class="fas fa-shopping-bag w-6"></i>
                            <span>Pesanan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.shipping.index') }}" class="{{ request()->routeIs('admin.shipping.*') ? 'bg-gray-700' : '' }} flex items-center p-2 text-base font-normal text-white rounded-lg hover:bg-gray-700">
                            <i class="fas fa-truck w-6"></i>
                            <span>Pengiriman</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'bg-gray-700' : '' }} flex items-center p-2 text-base font-normal text-white rounded-lg hover:bg-gray-700">
                            <i class="fas fa-chart-bar w-6"></i>
                            <span>Laporan</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="p-4 border-t border-gray-700">
                <a href="{{ route('home') }}" class="flex items-center p-2 text-base font-normal text-white rounded-lg hover:bg-gray-700">
                    <i class="fas fa-home w-6"></i>
                    <span>Kembali ke Toko</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center p-2 mt-2 text-base font-normal text-white rounded-lg hover:bg-gray-700">
                        <i class="fas fa-sign-out-alt w-6"></i>
                        <span>Log Out</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top navbar -->
            <div class="bg-white shadow px-6 py-3 flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">
                    @yield('header', 'Dashboard')
                </h2>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">{{ Auth::user()->name }}</span>
                </div>
            </div>

            <!-- Main content -->
            <div class="flex-1 overflow-auto p-6 bg-gray-50">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
