<?php

namespace App\Filament\Resources\ResponseResource\Pages;

use App\Filament\Resources\ResponseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateResponse extends CreateRecord
{
    protected static string $resource = ResponseResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }


}
