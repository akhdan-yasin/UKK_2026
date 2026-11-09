<?php

namespace App\Filament\Siswa\Widgets;

use App\Models\Pengaduan as PengaduanModel;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GetPengaduan extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?bool $isLazyLoaded = false;

    protected function getStats(): array
    {
        $siswaId = filter_var(
            $this->pageFilters['siswa_id'] ?? null,
            FILTER_VALIDATE_INT,
        );

        $counts = $siswaId
            ? PengaduanModel::query()
                ->where('siswa_id', $siswaId)
                ->select('status')
                ->selectRaw('COUNT(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status')
            : collect();

        return [
            Stat::make('Menunggu', $siswaId ? $counts->get('menunggu', 0) : '—')
                ->color('warning'),
            Stat::make('Proses', $siswaId ? $counts->get('proses', 0) : '—')
                ->color('info'),
            Stat::make('Selesai', $siswaId ? $counts->get('selesai', 0) : '—')
                ->color('success'),
        ];
    }
}
