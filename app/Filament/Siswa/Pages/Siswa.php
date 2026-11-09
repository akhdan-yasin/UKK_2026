<?php

namespace App\Filament\Siswa\Pages;

use App\Models\Siswa as SiswaModel;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Collection;

class Siswa extends Page
{
    protected static ?string $navigationLabel = 'Siswa';

    protected static ?string $title = 'Daftar Siswa';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.siswa.pages.siswa';

    /**
     * @return array{siswas: Collection<int, SiswaModel>}
     */
    protected function getViewData(): array
    {
        return [
            'siswas' => SiswaModel::query()
                ->select(['id', 'name', 'kelas'])
                ->orderBy('name')
                ->get(),
        ];
    }
}
