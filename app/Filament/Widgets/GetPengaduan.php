<?php

namespace App\Filament\Widgets;

use App\Models\Pengaduan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GetPengaduan extends BaseWidget
{
    protected function getStats(): array
    {
        $counts = Pengaduan::query()
            ->select('status')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            Stat::make('Menunggu', $counts->get('menunggu', 0))
                ->color('warning'),
            Stat::make('Proses', $counts->get('proses', 0))
                ->color('info'),
            Stat::make('Selesai', $counts->get('selesai', 0))
                ->color('success'),
        ];
    }
}
