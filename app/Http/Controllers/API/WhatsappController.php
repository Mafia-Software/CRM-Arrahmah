<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\SendMessageJob;
use Illuminate\Http\Request;
use App\Services\WhatsappService;

class WhatsAppController extends Controller
{
    protected $whatsAppService;

    public function __construct(WhatsappService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    public function send(Request $request)
    {
        $request->validate([
            'number' => 'required',
            'type' => 'required',
            'message' => 'required',
            'instance_id' => 'required',
            'access_token' => 'required',
        ]);

        $number = $request->input('number');
        $type = $request->input('type');
        $message = $request->input('message');
        $instance_id = $request->input('instance_id');

        // $response = $this->whatsAppService->sendMessage($number, $type, $message, $instance_id, $token);

        SendMessageJob::dispatch($number, $type, $message, $instance_id);
    }
}
