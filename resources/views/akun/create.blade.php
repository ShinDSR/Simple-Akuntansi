<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Create Data Akun') }}
        </h2>
    </x-slot>

    <div class="sm:py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white dark:bg-gray-800 sm:shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="post" action="{{ route('akun.store') }}" class="">
                        @csrf
                        @method('post')
                        <div class="mb-6">
                            <x-input-label for="kode_akun" :value="__('Kode Akun')" />
                            <x-text-input id="kode_akun" name="kode_akun" type="text" class="block w-full mt-1" required
                                autofocus autocomplete="kode_akun" :value="old('kode_akun')" />
                            <x-input-error class="mt-2" :messages="$errors->get('kode_akun')" />
                        </div>
                        <div class="mb-6">
                            <x-input-label for="nama_akun" :value="__('Nama Akun')" />
                            <x-text-input id="nama_akun" name="nama_akun" type="text" class="block w-full mt-1" required
                                autofocus autocomplete="nama_akun" :value="old('nama_akun')" />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_akun')" />
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                            <x-cancel-button href="{{ route('akun.index') }}" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
