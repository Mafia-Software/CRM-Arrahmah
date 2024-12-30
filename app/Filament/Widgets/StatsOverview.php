<?php

namespace App\Filament\Widgets;

use App\Models\PesanKeluar;
use App\Models\PesanMasuk;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    /**
     * Get the stats for the widget.
     *
     * @return array
     */
    protected function getStats(): array
    {
        $totalFeedback = PesanMasuk::count();
        $totalTerbaca = PesanKeluar::where('status', 4)->count();
        $totalTerkirim = PesanKeluar::whereIn('status', [2, 200])->count();

        return [
            Stat::make('Feedback', $totalFeedback),
            Stat::make('Terbaca', $totalTerbaca),
            Stat::make('Terkirim', $totalTerkirim),
        ];
    }
}
