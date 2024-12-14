<?php

namespace App\Filament\Resources\ContentPlannerResource\Pages;

use App\Filament\Resources\ContentPlannerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContentPlanner extends EditRecord
{
    protected static string $resource = ContentPlannerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
