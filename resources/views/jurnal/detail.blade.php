<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Detail Data Jurnal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-xl text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <x-create-button href="{{ route('jurnal.create') }}" />
                        </div>
                        <div>
                            @if (session('success'))
                            <p x-data="{ show: true }" x-show="show" x-transition
                                x-init="setTimeout(() => show = false, 5000)"
                                class="text-sm text-green-600 dark:text-green-400">{{ session('success') }}
                            </p>
                            @endif
                            @if (session('danger'))
                            <p x-data="{ show: true }" x-show="show" x-transition
                                x-init="setTimeout(() => show = false, 5000)"
                                class="text-sm text-red-600 dark:text-red-400">{{ session('danger') }}
                            </p>
                            @endif
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
                                    Tanggal
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Akun
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Debet
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Kredit
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @forelse ($list_jurnal as $data)
                            <tr class="odd:bg-white odd:dark:bg-gray-800 even:bg-gray-50 even:dark:bg-gray-700">
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    <p>
                                        {{ $no++ }}
                                    </p>
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    <p>
                                        {{ $data->tgl_transaksi }}
                                    </p>
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    <p>
                                        {{ $data->akun->nama_akun }}
                                    </p>
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    <p>
                                        @if ($data->tipe_transaksi == 'd')
                                            Rp. {{ number_format($data->nominal, 0, ',', '.') }},-
                                        @else
                                            -
                                        @endif
                                    </p>
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    <p>
                                        @if ($data->tipe_transaksi == 'k')
                                            Rp. {{ number_format($data->nominal, 0, ',', '.') }},-
                                        @else
                                            -
                                        @endif
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-3">
                                    <form action="{{ route('jurnal.edit', $data) }}" method="Post">
                                            @csrf
                                            @method('GET')
                                            <button type="submit" class="text-green-600 dark:text-green-400">
                                                Edit
                                            </button>
                                        </form>
                                        <form action="{{ route('jurnal.destroy', $data) }}" method="Post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-400">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
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
                    </table>
                    <table class="w-full text-sm text-left text-blue-500 dark:text-blue-400">
                        <tfoot class="text-xs text-blue-700 uppercase bg-blue-300 dark:bg-blue-700 dark:text-blue-100">
                            <tr>
                                <th class="px-5 py-3 text-center">
                                </th>
                                <th class="px-10 py-3 text-center">
                                        TOTAL
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                        Rp. {{ number_format($total_debet, 0, ',', '.') }},-
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                        Rp. {{ number_format($total_kredit, 0, ',', '.') }},-
                                </th>
                                @if ($total_debet == $total_kredit)
                                <th scope="col" class="px-2 py-3 text-center text-xs text-green-700 uppercase bg-green-400 dark:bg-green-600 dark:text-green-200">
                                        BALANCE
                                </th>
                                @else
                                <th scope="col" class="px-2 py-3 text-center text-xs text-red-700 uppercase bg-red-400 dark:bg-red-600 dark:text-red-200">
                                        UNBALANCE
                                </th>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                    <br>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <x-cancel-button href="{{ route('jurnal.index') }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
