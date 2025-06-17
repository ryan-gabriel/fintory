{{-- resources/views/auth/choose_role.blade.php --}}
<link rel="icon" type="image/png" href="{{ asset('images/fintory.png') }}">
<title>{{ __('Pilih role') }}</title>
<x-app-layout>
    {{-- If your <x-app-layout> accepts a “header” slot, you can set the page title there: --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Choose Role & Lembaga') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">
                        {{ __('Select which Role & Lembaga you want to act as:') }}
                    </h3>

                    @if($errors->any())
                        <div class="mb-4 text-red-600 dark:text-red-400">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('auth.pick_role') }}">
                        @csrf

                        <div class="space-y-4">
                            @foreach($combos as $role)
                                @php
                                    // pivot holds lembaga_id
                                    $lembaga = \App\Models\Lembaga::find($role->pivot->lembaga_id);
                                @endphp

                                <div class="flex items-center p-3 border rounded-lg bg-gray-50 dark:bg-gray-700">
                                    <input
                                        id="role_{{ $role->id }}_lem_{{ $role->pivot->lembaga_id }}"
                                        name="role_id"
                                        type="radio"
                                        value="{{ $role->id }}"
                                        class="h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600 focus:ring-indigo-500 dark:focus:ring-indigo-400"
                                        required
                                        @if(old('role_id') == $role->id) checked @endif
                                    />

                                    <label for="role_{{ $role->id }}_lem_{{ $role->pivot->lembaga_id }}"
                                           class="ml-3 block text-gray-700 dark:text-gray-200 cursor-pointer">
                                        <span class="font-medium">{{ ucfirst($role->role_name) }}</span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            — in “{{ $lembaga->name }}”
                                        </span>
                                        {{-- we need lembaga_id alongside role_id --}}
                                        <input type="hidden"
                                               name="lembaga_id"
                                               value="{{ $role->pivot->lembaga_id }}">
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            <x-primary-button class="w-full justify-center">
                                {{ __('Continue') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
