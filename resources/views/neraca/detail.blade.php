<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Detail Neraca Saldo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-xl text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p>{{ $periode }}</p>
                        </div>
                    </div>
                </div>

                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">NO</th>
                                <th scope="col" class="px-6 py-3">Kode Akun</th>
                                <th scope="col" class="px-6 py-3">Nama Akun</th>
                                <th scope="col" class="px-6 py-3">Aktiva</th>
                                <th scope="col" class="px-6 py-3">Pasiva</th>
                                <th scope="col" class="px-6 py-3">Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($jurnal_details as $jurnal)
                            <tr class="odd:bg-white odd:dark:bg-gray-800 even:bg-gray-50 even:dark:bg-gray-700">
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $no++ }}
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $jurnal->akun->kode_akun }}
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $jurnal->akun->nama_akun }}
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $jurnal->total_debet }}
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $jurnal->nominal }}
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

                <div class="p-6 text-xl text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <x-cancel-button href="{{ route('neraca.index') }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>