<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Log;
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

            default:
                break;
        }
    }
}
