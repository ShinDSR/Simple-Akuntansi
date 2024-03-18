<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Data Jurnal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="post" action="{{ route('jurnal.update', $jurnal) }}" class="">
                        @csrf
                        @method('patch')
                        <div class="mb-6">
                            <x-input-label for="tgl_transaksi" :value="__('Tanggal Transaksi')" />
                            <x-text-input id="tgl_transaksi" name="tgl_transaksi" type="date" class="block w-full mt-1" required
                                autofocus autocomplete="tgl_transaksi" :value="old('tgl_transaksi', $jurnal->tgl_transaksi)" />
                            <x-input-error class="mt-2" :messages="$errors->get('tgl_transaksi')" />
                        </div>
                        <div class="mb-6">
                            <x-input-label for="akun_id" :value="__('Tipe Akun')" />
                            <x-select id="akun_id" name="akun_id" class="block w-full mt-1">
                                <option value="">-- Pilih Akun --</option>
                                @foreach ($akuns as $akun)
                                <option value="{{ $akun->id }}" {{ ($jurnal->akun && $akun->id == $jurnal->akun->id) ?
                                    'selected' : '' }}>
                                    {{ $akun->nama_akun }}
                                </option>
                                @endforeach
                            </x-select>
                            <x-input-error class="mt-2" :messages="$errors->get('akun_id')" />
                        </div>
                        <div class="mb-6">
                            <x-input-label for="nominal" :value="__('Nominal')" />
                            <x-text-input id="nominal" name="nominal" type="number" class="block w-full mt-1" required
                                autofocus autocomplete="nominal" :value="old('nominal', $jurnal->nominal)" />
                            <x-input-error class="mt-2" :messages="$errors->get('nominal')" />
                        </div>
                        <div class="mb-6">
                            <x-input-label for="keterangan" :value="__('Keterangan')" />
                            <x-text-input id="keterangan" name="keterangan" type="text" class="block w-full mt-1" required
                                autofocus autocomplete="keterangan" :value="old('keterangan', $jurnal->keterangan)" />
                            <x-input-error class="mt-2" :messages="$errors->get('keterangan')" />
                        </div>
                        <div class="mb-6">
                            <x-input-label for="tipe_transaksi" :value="__('Tipe Transaksi')" />
                            <x-select id="tipe_transaksi" name="tipe_transaksi" class="block w-full mt-1">
                                <option>-- Pilih Tipe Transaksi --</option>
                                <option value="d" {{ ($jurnal->tipe_transaksi == 'd') ? 'selected' : '' }}>DEBET</option>
                                <option value="k" {{ ($jurnal->tipe_transaksi == 'k') ? 'selected' : '' }}>KREDIT</option>
                            </x-select>
                            <x-input-error class="mt-2" :messages="$errors->get('tipe_transaksi')" />
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                            <x-cancel-button href="{{ route('jurnal.index') }}" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
