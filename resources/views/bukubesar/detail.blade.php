<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Detail Buku Besar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-xl text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            Nama Akun : {{ $akun->nama_akun }}
                        </div>
                        <div>
                            Periode : {{ $periode }}
                        </div>
                        <div>
                            Kode Akun : {{ $akun->kode_akun }}
                        </div>
                    </div>
                </div>

                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    NO
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Tanggal Transaksi
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Keterangan
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Debet
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Kredit
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @forelse ($jurnals as $jurnal)
                            <tr class="odd:bg-white odd:dark:bg-gray-800 even:bg-gray-50 even:dark:bg-gray-700">
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    <p>
                                        {{ $no++ }}
                                    </p>
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    <p>
                                        {{ $jurnal->tgl_transaksi }}
                                    </p>
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    <p>
                                        {{ $jurnal->keterangan }}
                                    </p>
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    <p>
                                        @if ($jurnal->tipe_transaksi == 'd')
                                            Rp. {{ number_format($jurnal->nominal, 0, ',', '.') }},-
                                        @else
                                            -
                                        @endif
                                    </p>
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    <p>
                                        @if ($jurnal->tipe_transaksi == 'k')
                                            Rp. {{ number_format($jurnal->nominal, 0, ',', '.') }},-
                                        @else
                                            -
                                        @endif
                                    </p>
                                </td>
                                
                            </tr>
                            @empty
                            <tr class="bg-white dark:bg-gray-800">
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    Empty
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="text-blue-700 uppercase bg-blue-300 dark:bg-blue-700 dark:text-blue-100 text-base">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                </th>
                                <th scope="col" class="px-6 py-3">
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Total
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Rp. {{ number_format($total_debet, 0, ',', '.') }},-
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Rp. {{ number_format($total_kredit, 0, ',', '.') }},-
                                </th>
                            </tr>
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                </th>
                                <th scope="col" class="px-6 py-3">
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Saldo
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Rp. {{ number_format($saldo, 0, ',', '.') }},-
                                </th>
                                <th scope="col" class="px-6 py-3">
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="p-6 text-xl text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <x-cancel-button href="{{ route('bukubesar.index') }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
