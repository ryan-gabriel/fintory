<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Selamat datang! Untuk melanjutkan, silakan buat lembaga/organisasi Anda terlebih dahulu.') }}
    </div>

    <form method="POST" action="{{ route('auth.setup.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Lembaga Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lembaga/Organisasi')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="organization" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Industry -->
        <div class="mt-4">
            <x-input-label for="industry" :value="__('Bidang Usaha/Industri')" />
            <x-text-input id="industry" class="block mt-1 w-full" type="text" name="industry" :value="old('industry')" autocomplete="organization-title" />
            <x-input-error :messages="$errors->get('industry')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Nomor Telepon')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email Lembaga')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Address -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Alamat')" />
            <textarea id="address" name="address" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('address') }}</textarea>
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Logo Upload -->
        <div class="mt-4">
            <x-input-label for="logo" :value="__('Logo Lembaga (Opsional)')" />
            <input type="file" name="logo" id="logo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-full file:border-0
                       file:text-sm file:font-semibold
                       file:bg-blue-50 file:text-blue-700
                       hover:file:bg-blue-100
                       dark:file:bg-gray-700 dark:file:text-blue-300
                       dark:hover:file:bg-gray-600" />
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Maksimal 2MB. Format: JPG, PNG, GIF') }}</p>
            <x-input-error :messages="$errors->get('logo')" class="mt-2" />
        </div>

        <!-- Info Trial -->
        <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/50 border border-blue-200 dark:border-blue-800 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                        {{ __('Trial Gratis 14 Hari') }}
                    </h3>
                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                        <p>{{ __('Setelah lembaga dibuat, Anda akan mendapat akses trial gratis selama 14 hari untuk mencoba semua fitur.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-4">
                {{ __('Buat Lembaga & Mulai Trial') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>