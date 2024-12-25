<?php

namespace App\Filament\Resources\ContentPlannerResource\Pages;

use App\Filament\Resources\ContentPlannerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContentPlanner extends CreateRecord
{
    protected static string $resource = ContentPlannerResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
