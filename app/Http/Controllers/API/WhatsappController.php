<?php

namespace App\Http\Controllers\API;

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
            'message' => 'required',
            'instance_id' => 'required',
        ]);
        $response = $this->whatsAppService->sendMessage($validated['number'], $validated['message'], $validated['instance_id']);
        // SendWhatsAppMessageJob::dispatch(
        //     $validated['number'],
        //     $validated['message'],
        //     $validated['instance_id']
        // );

        return $response;
    }

    public function createInstance()
    {
        return $this->whatsAppService->createInstance();
    }

    public function getQR($instance_id)
    {
        return $this->whatsAppService->getQR($instance_id);
    }
}
