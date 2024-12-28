<?php

namespace App\Filament\Resources\WhatsAppServerResource\Pages;

use App\Filament\Resources\WhatsAppServerResource;
use App\Http\Controllers\API\WhatsappController;
use App\Services\WhatsappService;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateWhatsAppServer extends CreateRecord
{
    protected static string $resource = WhatsAppServerResource::class;
    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function handleRecordCreation(array $data): Model
    {
        $wa = new WhatsappController(new WhatsappService());
        $response = $wa->addDevice($data['no_wa'], $data['nama']);
        if ($response->getData()->status != true) {
            Notification::make()->danger()->title('Error')->body($response->getData()->message)->send();
            $this->halt();
        }
        $data['api_key'] = $response->getData()->apiKey;
        $data['service_status'] = 'SERVICE_OFF';
        return static::getModel()::create($data);
    }
}
