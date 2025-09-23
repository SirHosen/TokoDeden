<!-- resources/views/errors/500.blade.php -->
<x-app-layout>
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="text-center">
                <h2 class="text-6xl font-bold text-red-600 mb-4">500</h2>
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">Terjadi Kesalahan Server</h3>
                <p class="text-gray-600 mb-8">Maaf, terjadi kesalahan pada server. Tim kami sedang menangani masalah ini.</p>
                <div class="space-y-4">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 transition">
                        <i class="fas fa-home mr-2"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
