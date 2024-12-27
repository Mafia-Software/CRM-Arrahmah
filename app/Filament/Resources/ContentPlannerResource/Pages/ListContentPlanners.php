<?php

namespace App\Filament\Resources\ContentPlannerResource\Pages;

use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ContentPlannerResource;
use App\Filament\Resources\ContentPlannerResource\Widgets\CalendarWidget;

class ListContentPlanners extends ListRecords
{
    protected static string $resource = ContentPlannerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make()->label('Tambah Content Planner'),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        
        return [
            CalendarWidget::class
        ];
    }


         

   
}
