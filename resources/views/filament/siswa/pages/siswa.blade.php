<x-filament-panels::page>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($siswas as $siswa)
            <x-filament::section>
                <h2 class="text-lg font-semibold text-gray-950 dark:text-white">
                    {{ $siswa->name }}
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Kelas: {{ $siswa->kelas }}
                </p>
            </x-filament::section>
        @empty
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Belum ada data siswa.
            </p>
        @endforelse
    </div>
</x-filament-panels::page>
