<?php

namespace App\Filament\Siswa\Widgets;

use App\Models\Pengaduan;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;

class PengaduanTable extends TableWidget
{
    use InteractsWithPageFilters;

    protected static ?bool $isLazyLoaded = false;

    public function table(Table $table): Table
    {
        return $table
            ->query(function (): Builder {
                $siswaId = filter_var(
                    $this->pageFilters['siswa_id'] ?? null,
                    FILTER_VALIDATE_INT,
                );

                return Pengaduan::query()
                    ->with('category')
                    ->when(
                        $siswaId,
                        fn (Builder $query): Builder => $query->where('siswa_id', $siswaId),
                        fn (Builder $query): Builder => $query->whereRaw('1 = 0'),
                    );
            })
            ->columns([
                TextColumn::make('nama')
                    ->label('Pengaduan')
                    ->searchable(),
                TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('ruangan')
                    ->label('Ruangan')
                    ->searchable(),
                TextColumn::make('kapan')
                    ->label('Waktu')
                    ->time()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->searchable(),
            ]);
    }
}
