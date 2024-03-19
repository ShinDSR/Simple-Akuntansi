<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Buku Besar {{ __( $akun->nama_akun) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                

                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    NO
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Bulan
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @forelse ($list_buku as $data)
                            <tr class="odd:bg-white odd:dark:bg-gray-800 even:bg-gray-50 even:dark:bg-gray-700">
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    <p>
                                        {{ $no++ }}
                                    </p>
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    <p>
                                        {{ date('F Y', strtotime('1-'.$data->tanggal)) }}
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-3">
                                        <form action="{{ url('bukubesar/detail/'.$akun->id.'/'.date('Y-m-d', strtotime('1-'.$data->tanggal)))}}" method="Post">
                                            @csrf
                                            @method('GET')
                                            <button type="submit" class="text-blue-600 dark:text-blue-400">
                                                Detail
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
                    <br>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <x-cancel-button href="{{ route('bukubesar.index') }}" />
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
