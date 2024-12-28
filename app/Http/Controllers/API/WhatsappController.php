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

    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required',
            'message' => 'required',
        ]);
        $apiKey = 'test';
        return $this->whatsAppService->sendMessage($apiKey, $validated['number'], $validated['message']);
        // SendWhatsAppMessageJob::dispatch(
        //     $validated['number'],
        //     $validated['message'],
        //     $validated['instance_id']
        // );
    }
    public function getQR(string $apiKey)
    {
        return $this->whatsAppService->getQR($apiKey);
    }

    public function sendMediaFromUrl()
    {
    }
    public function addDevice($number, $name_device)
    {
        $apiKey = str()->random();
        $response = $this->whatsAppService->addDevice($apiKey, $number, $name_device);
        return response()->json([
            'response' => $response['status'],
            'apiKey' => $apiKey
        ]);
    }
}
