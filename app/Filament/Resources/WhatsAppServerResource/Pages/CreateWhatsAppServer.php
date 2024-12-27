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

     protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');

    }

    protected function handleRecordCreation(array $data): Model
    {
        $wa = new WhatsappController(new WhatsappService);
        $response = $wa->createInstance();
        if ($response['instance_id'] == null) {
            Notification::make()->danger()->title('Error')->body($response['error'])->send();
            $this->cancel();
        }
        $data['instance_id'] = $response['instance_id'];

        return static::getModel()::create($data);
    }
}
