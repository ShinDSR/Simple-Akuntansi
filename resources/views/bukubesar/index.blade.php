<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Buku Besar') }}
        </h2>
    </x-slot>

    <div class="sm:py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white dark:bg-gray-800 sm:shadow-sm sm:rounded-lg">
                <div class="panel-body">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
                        @forelse ($akuns as $data)
                            <div class="m-2">
                                <a href="{{ route('bukubesar.periode', $data) }}" class="inline-block w-full px-6 py-3 bg-blue-500 text-white rounded-lg text-center hover:bg-blue-600 transition duration-300">
                                    {{ $data->nama_akun }}
                                </a>
                            </div>
                        @empty
                            <div class="m-2">
                                <p class="px-4 py-2 bg-gray-200 dark:bg-gray-700 dark:text-white">Empty</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>