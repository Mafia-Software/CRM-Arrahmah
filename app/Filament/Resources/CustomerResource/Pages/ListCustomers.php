<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use App\Filament\Imports\DataImporter;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CustomerResource;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make('import')->label('Import Donatur DB')->importer(DataImporter::class),
            CreateAction::make()->label('Tambah Customer'),
        ];
    }
}
