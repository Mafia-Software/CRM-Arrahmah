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
        $response = $this->whatsAppService->getQR($apiKey);

        return response()->json([
            'status' => $response['code'],
            'qr' => $response['results']['qrString']
        ]);
    }

    public function sendMediaFromUrl() {}
    public function startService($apiKey)
    {
        return $this->whatsAppService->startService($apiKey);
    }

    public function getState($apiKey)
    {
        return $this->whatsAppService->getState($apiKey);
    }
    public function addDevice($number, $name_device)
    {
        $apiKey = str()->random();
        $response = $this->whatsAppService->addDevice($apiKey, $number, $name_device);
        return response()->json([
            'status' => $response['status'],
            'apiKey' => $apiKey
        ]);
    }
}
