<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Perusahaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-xl text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p>Data Perusahaan</p>
                        </div>
                        @forelse ($offices as $office)
                        <div>
                            <form action="{{ route('office.edit', $office) }}" method="Post">
                                @csrf
                                @method('GET')
                                <button type="submit" class="inline-block px-6 py-3 bg-blue-500 text-white rounded-lg text-center hover:bg-blue-600 transition duration-300">
                                    Edit
                                </button>
                            </form>
                        </div>
                        @empty
                        <div>
                            <form action="{{ route('office.create') }}" method="Post">
                                @csrf
                                @method('GET')
                                <button type="submit" class="inline-block px-6 py-3 bg-blue-500 text-white rounded-lg text-center hover:bg-blue-600 transition duration-300">
                                    Create
                                </button>
                            </form>
                        </div>
                        @endforelse
                    </div>
                </div>

                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        
                        <tbody>
                            @forelse ($offices as $office)
                            <tr class="odd:bg-white odd:dark:bg-gray-800 even:bg-gray-50 even:dark:bg-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white text-center">
                                    {{ __('Nama Perusahaan') }}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white text-center">
                                    {{ $office->nama_perusahaan }}
                                </th>
                            </tr>
                            <tr class="odd:bg-white odd:dark:bg-gray-800 even:bg-gray-50 even:dark:bg-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white text-center">
                                    {{ __('Alamat') }}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white text-center">
                                    {{ $office->alamat }}
                                </th>
                            </tr>
                            <tr class="odd:bg-white odd:dark:bg-gray-800 even:bg-gray-50 even:dark:bg-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white text-center">
                                    {{ __('No Telp') }}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white text-center">
                                    {{ $office->no_telp }}
                                </th>
                            </tr>
                            <tr class="odd:bg-white odd:dark:bg-gray-800 even:bg-gray-50 even:dark:bg-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white text-center">
                                    {{ __('Email') }}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white text-center">
                                    {{ $office->email }}
                                </th>
                            </tr>
                            <tr class="odd:bg-white odd:dark:bg-gray-800 even:bg-gray-50 even:dark:bg-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white text-center">
                                    {{ __('Tanggal Berdiri') }}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white text-center
                                ">
                                    {{ $office->tgl_berdiri }}
                                </th>
                            </tr>
                            @empty
                            <tr class="odd:bg-white odd:dark:bg-gray-800 even:bg-gray-50 even:dark:bg-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white text-center">
                                    Empty
                                </th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
