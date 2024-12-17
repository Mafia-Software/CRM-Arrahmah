<?php

namespace App\Http\Controllers;

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
        $sender = $request->input('instance_id');
        $token = $request->input('access_token');

        $response = $this->whatsAppService->sendMessage($number, $type, $message, $instance, $token);

        return response()->json($response);
    }
}
