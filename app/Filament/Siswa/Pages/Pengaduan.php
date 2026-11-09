<?php

namespace App\Filament\Siswa\Pages;

use App\Filament\Siswa\Widgets\GetPengaduan;
use App\Filament\Siswa\Widgets\PengaduanTable;
use App\Models\Siswa;
use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Schema;

class Pengaduan extends Dashboard
{
    use HasFiltersForm;

    protected static string $routePath = '/pengaduan';

    protected static ?string $navigationLabel = 'Pengaduan';

    protected static ?string $title = 'Pengaduan';

    protected static ?int $navigationSort = 2;

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('siswa_id')
                    ->label('Pilih Siswa')
                    ->options(fn (): array => Siswa::query()
                        ->orderBy('name')
                        ->pluck('name', 'id')
                        ->all())
                    ->searchable()
                    ->placeholder('Pilih siswa untuk melihat pengaduan'),
            ]);
    }

    public function getWidgets(): array
    {
        return [
            GetPengaduan::class,
            PengaduanTable::class,
        ];
    }

    public function getColumns(): int
    {
        return 1;
    }
}
