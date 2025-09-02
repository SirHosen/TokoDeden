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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.44.0/apexcharts.min.js"></script>

    <!-- Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .sidebar-menu-item:hover .sidebar-icon {
            transform: translateX(5px);
            transition: transform 0.2s;
        }
        .dashboard-card {
            transition: all 0.3s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .gradient-green {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        }
        /* Custom scrollbar for sidebar */
        .scrollbar-thin::-webkit-scrollbar {
            width: 5px;
        }
        .scrollbar-thin::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar - Fixed Position -->
        <div class="w-72 bg-gradient-to-b from-gray-900 to-gray-800 text-white fixed inset-y-0 left-0 z-30 flex flex-col shadow-xl" x-data="{ open: false }">
            <div class="p-6 border-b border-gray-700/50 flex items-center space-x-4">
                <div class="rounded-full bg-gradient-green p-2 flex items-center justify-center">
                    <i class="fas fa-store text-white text-xl"></i>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                    <h1 class="text-xl font-bold tracking-tight">Toko Deden <span class="text-green-400 ml-1">Admin</span></h1>
                </a>
            </div>
            <div class="flex-1 overflow-y-auto py-6 px-4 scrollbar-thin">
                <div class="mb-6">
                    <p class="uppercase text-xs font-semibold tracking-wider text-gray-400 mb-4 pl-3">Menu Utama</p>
                    <ul class="space-y-3">
                        <li class="sidebar-menu-item">
                            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white border-l-4 border-green-500' : 'text-gray-300 hover:bg-gray-800/60' }} flex items-center px-4 py-3 text-base font-medium rounded-lg transition-all">
                                <i class="fas fa-tachometer-alt text-lg sidebar-icon {{ request()->routeIs('admin.dashboard') ? 'text-green-400' : 'text-gray-400' }} w-6 transition-transform"></i>
                                <span class="ml-3">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'bg-gray-700 text-white border-l-4 border-green-500' : 'text-gray-300 hover:bg-gray-800/60' }} flex items-center px-4 py-3 text-base font-medium rounded-lg transition-all">
                                <i class="fas fa-box text-lg sidebar-icon {{ request()->routeIs('admin.products.*') ? 'text-green-400' : 'text-gray-400' }} w-6 transition-transform"></i>
                                <span class="ml-3">Produk</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'bg-gray-700 text-white border-l-4 border-green-500' : 'text-gray-300 hover:bg-gray-800/60' }} flex items-center px-4 py-3 text-base font-medium rounded-lg transition-all">
                                <i class="fas fa-tags text-lg sidebar-icon {{ request()->routeIs('admin.categories.*') ? 'text-green-400' : 'text-gray-400' }} w-6 transition-transform"></i>
                                <span class="ml-3">Kategori</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="mb-6">
                    <p class="uppercase text-xs font-semibold tracking-wider text-gray-400 mb-4 pl-3">Transaksi</p>
                    <ul class="space-y-3">
                        <li class="sidebar-menu-item">
                            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'bg-gray-700 text-white border-l-4 border-green-500' : 'text-gray-300 hover:bg-gray-800/60' }} flex items-center px-4 py-3 text-base font-medium rounded-lg transition-all">
                                <i class="fas fa-shopping-bag text-lg sidebar-icon {{ request()->routeIs('admin.orders.*') ? 'text-green-400' : 'text-gray-400' }} w-6 transition-transform"></i>
                                <span class="ml-3">Pesanan</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="{{ route('admin.shipping.index') }}" class="{{ request()->routeIs('admin.shipping.*') ? 'bg-gray-700 text-white border-l-4 border-green-500' : 'text-gray-300 hover:bg-gray-800/60' }} flex items-center px-4 py-3 text-base font-medium rounded-lg transition-all">
                                <i class="fas fa-truck text-lg sidebar-icon {{ request()->routeIs('admin.shipping.*') ? 'text-green-400' : 'text-gray-400' }} w-6 transition-transform"></i>
                                <span class="ml-3">Pengiriman</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'bg-gray-700 text-white border-l-4 border-green-500' : 'text-gray-300 hover:bg-gray-800/60' }} flex items-center px-4 py-3 text-base font-medium rounded-lg transition-all">
                                <i class="fas fa-chart-bar text-lg sidebar-icon {{ request()->routeIs('admin.reports.*') ? 'text-green-400' : 'text-gray-400' }} w-6 transition-transform"></i>
                                <span class="ml-3">Laporan</span>
                                <span class="bg-green-500 ml-auto text-xs rounded-full px-2 py-1 font-semibold">Pro</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="p-4 border-t border-gray-700/50">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center p-3 text-base font-medium text-gray-300 rounded-lg hover:bg-gray-800 transition-all">
                        <i class="fas fa-sign-out-alt text-gray-400 w-6"></i>
                        <span class="ml-3">Log Out</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Content - With margin for fixed sidebar -->
        <div class="flex-1 flex flex-col overflow-hidden ml-72">
            <!-- Top navbar -->
            <div class="bg-white shadow-sm px-6 py-4 sticky top-0 z-20 flex items-center justify-between">
                <div class="flex items-center">
                    <h2 class="text-xl font-semibold text-gray-800">
                        @yield('header', 'Dashboard')
                    </h2>
                    <nav class="ml-6 text-sm">
                        <ol class="list-reset flex text-gray-500">
                            <li><a href="{{ route('admin.dashboard') }}" class="text-green-600 hover:text-green-800">Admin</a></li>
                            <li><span class="mx-2">/</span></li>
                            <li>@yield('header', 'Dashboard')</li>
                        </ol>
                    </nav>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative" x-data="{ isOpen: false }">
                        <button @click="isOpen = !isOpen" class="flex items-center space-x-3 focus:outline-none">
                            <div class="w-10 h-10 rounded-full bg-gradient-green flex items-center justify-center text-white font-semibold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">Administrator</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <div class="flex-1 overflow-auto p-8 bg-gray-100">
                @if (session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-md mb-6 flex items-center shadow-sm" role="alert">
                        <i class="fas fa-check-circle text-green-500 mr-3 text-lg"></i>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-md mb-6 flex items-center shadow-sm" role="alert">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3 text-lg"></i>
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
