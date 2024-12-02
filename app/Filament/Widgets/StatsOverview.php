<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Feedback', '500'),
            Stat::make('Terbaca', '2000'),
            Stat::make('Terkirim', '3000'),
            Stat::make('Tidak Menemukan Wangsaff', '1000'),
        ];
    }
}
