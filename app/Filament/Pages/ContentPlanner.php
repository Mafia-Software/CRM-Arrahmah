<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class ContentPlanner extends Page
{
    protected static ?string $navigationIcon = 'bi-graph-up-arrow';
    protected static ?int $navigationSort = 2;
    protected static ?string $title = 'Content Planner';
    protected static string $view = 'filament.pages.content-planner';
}
