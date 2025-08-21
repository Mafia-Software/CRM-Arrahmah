<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CalendarWidget;
use Filament\Pages\Page;

class ContentPlanner extends Page
{
    protected static ?string $navigationIcon = 'bi-graph-up-arrow';
    protected static ?string $navigationLabel = 'Content Planner';

    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pages.content-planner';

    protected function getHeaderWidgets(): array
    {
        return [
            CalendarWidget::class,
        ];
    }
}
