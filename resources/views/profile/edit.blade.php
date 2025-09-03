<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Profile card header -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-t-lg p-6 text-white">
                <div class="flex flex-col md:flex-row items-center md:items-end gap-4">
                    <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-md flex-shrink-0">
                        @if ($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-indigo-100 text-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                        <p class="text-sm font-medium text-indigo-100">{{ $user->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="bg-white border-b border-gray-200 shadow rounded-b-lg mb-6">
                <div x-data="{ activeTab: 'profile' }">
                    <!-- Tab navigation -->
                    <div class="flex border-b border-gray-200">
                        <button
                            @click="activeTab = 'profile'"
                            :class="{ 'border-b-2 border-indigo-500 text-indigo-600': activeTab === 'profile' }"
                            class="px-6 py-3 text-gray-600 font-medium text-sm hover:text-indigo-600 transition">
                            Informasi Profil
                        </button>
                        <button
                            @click="activeTab = 'address'"
                            :class="{ 'border-b-2 border-indigo-500 text-indigo-600': activeTab === 'address' }"
                            class="px-6 py-3 text-gray-600 font-medium text-sm hover:text-indigo-600 transition">
                            Alamat
                        </button>
                        <button
                            @click="activeTab = 'password'"
                            :class="{ 'border-b-2 border-indigo-500 text-indigo-600': activeTab === 'password' }"
                            class="px-6 py-3 text-gray-600 font-medium text-sm hover:text-indigo-600 transition">
                            Keamanan
                        </button>
                    </div>

                    <!-- Tab content -->
                    <div class="p-6">
                        <!-- Profile Information -->
                        <div x-show="activeTab === 'profile'" x-cloak>
                            @include('profile.partials.update-profile-information-form')
                        </div>

                        <!-- Address Form -->
                        <div x-show="activeTab === 'address'" x-cloak>
                            @include('profile.partials.update-address-form')
                        </div>

                        <!-- Password & Security -->
                        <div x-show="activeTab === 'password'" x-cloak>
                            <div class="mb-12">
                                @include('profile.partials.update-password-form')
                            </div>
                            <div class="border-t pt-10">
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview uploaded image script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imgInput = document.getElementById('profile_photo');
            if (imgInput) {
                imgInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const parent = imgInput.closest('.relative');
                            const imgContainer = parent.querySelector('img') || document.createElement('img');

                            if (!parent.contains(imgContainer)) {
                                // If there's a div placeholder, remove it
                                const placeholder = parent.querySelector('div:not(.absolute)');
                                if (placeholder) placeholder.remove();

                                imgContainer.classList.add('w-full', 'h-full', 'object-cover');
                                parent.querySelector('.w-32').prepend(imgContainer);
                            }

                            imgContainer.src = e.target.result;
                            imgContainer.alt = 'Preview';
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
</x-app-layout>
