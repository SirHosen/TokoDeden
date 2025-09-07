<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Toko Deden') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Page Content -->
        <main>
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mx-auto max-w-7xl my-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mx-auto max-w-7xl my-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            {{ $slot }}
        </main>

        <footer class="bg-gray-800 text-white py-10 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-xl font-semibold mb-4">Toko Deden</h3>
                        <p class="text-gray-300">Toko pakan ternak terlengkap dan terpercaya. Melayani berbagai kebutuhan pakan ternak Anda dengan harga terbaik.</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold mb-4">Hubungi Kami</h3>
                        <ul class="text-gray-300">
                            <li class="mb-2"><i class="fas fa-map-marker-alt mr-2"></i> Jl. Peternakan No. 123, Bekasi</li>
                            <li class="mb-2"><i class="fas fa-phone mr-2"></i> (021) 1234-5678</li>
                            <li><i class="fas fa-envelope mr-2"></i> info@tokodeden.com</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold mb-4">Jam Operasional</h3>
                        <ul class="text-gray-300">
                            <li class="mb-2">Senin - Jumat: 08.00 - 17.00</li>
                            <li class="mb-2">Sabtu: 08.00 - 15.00</li>
                            <li>Minggu: Tutup</li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-300">
                    &copy; {{ date('Y') }} Toko Deden. All rights reserved.
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
