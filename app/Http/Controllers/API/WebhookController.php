<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\PesanKeluar;
use App\Models\PesanMasuk;
use App\Models\WhatsappServer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::create([
            'type' => 'webhook',
            'logs' => json_encode($request->all())
        ]);
        switch ($request['type']) {
            case 'change_state':
                WhatsappServer::where('api_key', $request['results']['apiKey'])
                    ->update(['service_status' => $request['results']['state']]);
                return response('Sukses', 200);
                break;
            case 'message':
                $this->fromMe($request['results']);
                return response('Sukses', 200);
                break;
            case 'message_ack':
                $this->messageAck($request['results']['ack']);
                return response('Sukses', 200);
                break;
            case 'message_ack_browser':
                $this->messageAck($request['results']['ack']);
                return response('Sukses', 200);
                break;
            default:
                return response('Unhandled', 500);
                break;
        }
    }
    private function formatWhatsappNumber($whatsappNumber)
    {
        // Remove "@s.whatsapp.net" if it exists
        $cleanedNumber = Str::before($whatsappNumber, '@');

        // Check if the number starts with "62"
        if (Str::startsWith($cleanedNumber, '62')) {
            $formattedNumber = '0' . Str::substr($cleanedNumber, 2);
        } else {
            $formattedNumber = $cleanedNumber;
        }

        return $formattedNumber;
    }
    private function fromMe(array $request)
    {
        switch ($request['key']['fromMe']) {
            case false:
                $sender = WhatsappServer::where('api_key', $request['apiKey'])->first();
                $formattedNumber = $this->formatWhatsappNumber($request['from']);
                PesanMasuk::create([
                    'id' => $request['key']['id'],
                    'no_wa' => $formattedNumber,
                    'pesan' => $request['body'],
                    'wa_server_id' => $sender->id
                ]);
                break;
            case true:
                break;
            default:
                break;
        }
    }

    private function messageAck(array $request)
    {
        switch ($request['ack']) {
            case 2:
                PesanKeluar::where('id', $request['id'])->update(['status' => 2]);
                break;
            case 3:
                PesanKeluar::where('id', $request['id'])->update(['status' => 3]);
                break;
            case 4:
                PesanKeluar::where('id', $request['id'])->update(['status' => 4]);
                break;
        }
    }
}
