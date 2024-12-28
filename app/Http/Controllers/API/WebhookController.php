<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Log;
use App\Models\PesanMasuk;
use App\Models\WhatsappServer;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::create([
            'type' => 'webhook',
            'logs' => request()->all()
        ]);
        switch ($request['type']) {
            case 'change_state':
                WhatsappServer::where('api_key', $request['results']['apiKey'])
                    ->update(['service_status' => $request['results']['state']]);
                break;
            case 'message':
                $this->fromMe($request['results']);
                break;
            case 'message_ack':
                $this->messageAck($request['results']['ack']);
                break;
            case 'messsage_ack_browser':
                $this->messageAck($request['results']['ack']);
                break;
            default:
                break;
        }
    }

    private function fromMe(Request $request)
    {
        switch ($request['key']['fromMe']) {
            case false:
                $sender = WhatsappServer::where('api_key', $request['key']['apiKey'])->first();
                PesanMasuk::create([
                    'id' => $request['key']['id'],
                    'no_wa' => $request['key']['from'],
                    'pesan' => $request['body'],
                    'wa_server_id' => $sender->id
                ]);
                break;
            case true:
                $receiver = str_replace('@s.whatsapp.net', '', $request['key']['remotejid']);
                $receiver = substr($receiver, 2);
                $receiver = Customer::where('no_wa', '0' . $receiver)->first();
                PesanKeluar::create([
                    'id_wapi' => $request['key']['id'],
                    'customer_id' => $receiver->id ?? null,
                    'status' => 1,
                ]);
                break;
        }
    }

    private function messageAck(Request $request)
    {
        switch ($request['ack']['ack']) {
            case 2:
                PesanKeluar::where('id', $request['ack']['id'])->update(['status' => 2]);
                break;
            case 3:
                PesanKeluar::where('id', $request['ack']['id'])->update(['status' => 3]);
                break;
            case 4:
                PesanKeluar::where('id', $request['ack']['id'])->update(['status' => 4]);
                break;
        }
    }
}
