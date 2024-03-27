<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Create Data Perusahaan') }}
        </h2>
    </x-slot>

    <div class="sm:py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white dark:bg-gray-800 sm:shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="post" action="{{ route('office.store') }}" class="">
                        @csrf
                        @method('post')
                        <div class="mb-6">
                            <x-input-label for="nama_perusahaan" :value="__('Nama Perusahaan')" />
                            <x-text-input id="nama_perusahaan" name="nama_perusahaan" type="text" class="block w-full mt-1" required
                                autofocus autocomplete="nama_perusahaan" :value="old('nama_perusahaan')" />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_perusahaan')" />
                        </div>
                        <div class="mb-6">
                            <x-input-label for="alamat" :value="__('Alamat')" />
                            <x-text-input id="alamat" name="alamat" type="text" class="block w-full mt-1" required
                                autofocus autocomplete="alamat" :value="old('alamat')" />
                            <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
                        </div>
                        <div class="mb-6">
                            <x-input-label for="no_telp" :value="__('No. Telp')" />
                            <x-text-input id="no_telp" name="no_telp" type="text" class="block w-full mt-1" required
                                autofocus autocomplete="no_telp" :value="old('no_telp')" />
                            <x-input-error class="mt-2" :messages="$errors->get('no_telp')" />
                        </div>
                        <div class="mb-6">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="block w-full mt-1" required
                                autofocus autocomplete="email" :value="old('email')" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>
                        <div class="mb-6">
                            <x-input-label for="website" :value="__('Website')" />
                            <x-text-input id="website" name="website" type="text" class="block w-full mt-1" required
                                autofocus autocomplete="website" :value="old('website')" />
                            <x-input-error class="mt-2" :messages="$errors->get('website')" />
                        </div>
                        <div class="mb-6">
                            <x-input-label for="tanggal_berdiri" :value="__('Tanggal Berdiri')" />
                            <x-text-input id="tanggal_berdiri" name="tanggal_berdiri" type="date" class="block w-full mt-1" required
                                autofocus autocomplete="tanggal_berdiri" :value="old('tanggal_berdiri')" />
                            <x-input-error class="mt-2" :messages="$errors->get('tanggal_berdiri')" />
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                            <x-cancel-button href="{{ route('office.index') }}" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
