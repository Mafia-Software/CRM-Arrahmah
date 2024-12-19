<?php

namespace App\Http\Controllers\API;

use App\Jobs\SendMessageJob;
use Illuminate\Http\Request;
use App\Services\WhatsappService;
use App\Http\Controllers\Controller;
use App\Jobs\SendWhatsAppMessageJob;

class WhatsappController extends Controller
{
    protected $whatsAppService;

    public function __construct(WhatsappService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required',
            'type' => 'required',
            'message' => 'required',
            'instance_id' => 'required',
        ]);

        $number = $request->input('number');
        $type = $request->input('type');
        $message = $request->input('message');
        $instance_id = $request->input('instance_id');

        // $response = $this->whatsAppService->sendMessage($number, $type, $message, $instance_id, $token);
        SendWhatsAppMessageJob::dispatch(
            $validated['number'],
            $validated['type'],
            $validated['message'],
            $validated['instance_id']
        );

        return response()->json();
    }
}