<?php

namespace App\Filament\Resources\ContentPlannerResource\Pages;

use Filament\Facades\Filament;
use Filament\Resources\Pages\Page;
use App\Filament\Resources\ContentPlannerResource;
use App\Filament\Resources\ContentPlannerResource\Widgets\CalendarWidget;

class ContentPlannerPage extends Page
{
    protected static string $resource = ContentPlannerResource::class;

    protected static string $view = 'filament.resources.content-planner-resource.pages.content-planner-page';

    public function getWidgets(): array
    {
         return [
            CalendarWidget::class,  // Menambahkan widget CalendarWidget secara eksplisit
        ];
    }

}
