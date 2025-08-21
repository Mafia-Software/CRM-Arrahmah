<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\SendWhatsAppMessageJob;
use App\Jobs\SendWhatsAppMessageMediaJob;
use App\Models\History;
use App\Models\WhatsappServer;
use App\Services\WhatsappService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;

class WhatsappController extends Controller
{
    protected $whatsAppService;

    public function __construct(WhatsappService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    public function sendMessage($customers, $contentPlanner, $whatsappServer)
    {
        $history = History::create([
            'content_planner_id' => $contentPlanner->id,
            'user_id' => Auth::id(),
            'whatsapp_server_id' => $whatsappServer->id,
        ]);

        $jobs = [];
        $jumlahBatch = $whatsappServer->jumlahbatch;
        $delayBatch = $whatsappServer->delaybatch * 60;
        $delayMessage = $whatsappServer->delay;

        $totalCust = count($customers);
        $pesanPerBatch = ceil($totalCust / $jumlahBatch);

        $startTime = now();

        foreach (range(0, $jumlahBatch - 1) as $batchIndex) {
            $startIndex = $batchIndex * $pesanPerBatch;
            $endIndex = min($startIndex + $pesanPerBatch, $totalCust);
            $batchCustomers = $customers->slice($startIndex, $endIndex - $startIndex);

            foreach ($batchCustomers as $customerIndex => $customer) {
                $delay = $batchIndex * $delayBatch + $customerIndex * $delayMessage;
                $jobs[] = (new SendWhatsAppMessageJob($history->id, $whatsappServer->api_key, $customer, $contentPlanner))
                    ->delay($startTime->copy()->addSeconds($delay))
                ;
            }
        }
        $batch = Bus::batch($jobs)->dispatch();
        $history->update([
            'batch_id' => $batch->id,
        ]);

        return response()->json(['status' => true, 'message' => 'Pesan Berhasil Diproses']);
    }

    public function sendMessageMedia($customers, $contentPlanner, $whatsappServer)
    {
        $history = History::create([
            'content_planner_id' => $contentPlanner->id,
            'user_id' => Auth::id(),
            'whatsapp_server_id' => $whatsappServer->id,
        ]);

        $jobs = [];
        $jumlahBatch = $whatsappServer->jumlahbatch;
        $delayBatch = $whatsappServer->delaybatch * 60;
        $delayMessage = $whatsappServer->delay;

        $totalCust = count($customers);
        $pesanPerBatch = ceil($totalCust / $jumlahBatch);

        $startTime = now();

        foreach (range(0, $jumlahBatch - 1) as $batchIndex) {
            $startIndex = $batchIndex * $pesanPerBatch;
            $endIndex = min($startIndex + $pesanPerBatch, $totalCust);
            $batchCustomers = $customers->slice($startIndex, $endIndex - $startIndex);

            foreach ($batchCustomers as $customerIndex => $customer) {
                $delay = $batchIndex * $delayBatch + $customerIndex * $delayMessage;
                $jobs[] = (new SendWhatsAppMessageMediaJob($history->id, $whatsappServer->api_key, $customer, $contentPlanner))
                    ->delay($startTime->copy()->addSeconds($delay))
                ;
            }
        }
        $batch = Bus::batch($jobs)->dispatch();
        $history->update([
            'batch_id' => $batch->id,
        ]);

        return response()->json(['status' => true, 'message' => 'Pesan Berhasil Diproses']);
    }

    public function getQR(string $apiKey)
    {
        $response = $this->whatsAppService->getQR($apiKey);
        if (200 == $response['code']) {
            return response()->json([
                'status' => $response['code'],
                'qr' => $response['results']['qrString'],
            ]);
        }

        return response()->json([
            'status' => $response['code'],
            'message' => $response['results']['message'],
        ]);
    }

    public function sendMediaFromUrl() {}

    public function startService($apiKey)
    {
        $response = $this->whatsAppService->startService($apiKey);
        if (200 == $response['code']) {
            $state = $this->whatsAppService->getState($apiKey);
            if (200 == $state['code']) {
                WhatsappServer::where('api_key', $apiKey)->update(['service_status' => $state['results']['state']]);
            }

            return response()->json(['status' => true, 'message' => 'Service started successfully']);
        }

        return $response;
    }

    public function getState($apiKey)
    {
        return $this->whatsAppService->getState($apiKey);
    }

    public function addDevice($number, $name_device)
    {
        $apiKey = str()->random();
        $response = $this->whatsAppService->addDevice($apiKey, $number, $name_device);

        return response()->json(['status' => $response['status'], 'message' => $response['message'], 'apiKey' => $apiKey]);
    }

    public function stopService($apiKey)
    {
        $response = $this->whatsAppService->stopService($apiKey);
        if (200 == $response['code']) {
            $state = $this->whatsAppService->getState($apiKey);
            if (200 == $state['code']) {
                WhatsappServer::where('api_key', $apiKey)->update(['service_status' => $state['results']['state']]);
            }

            return response()->json(['status' => true, 'message' => 'Service stopped successfully']);
        }

        return $response;
    }

    public function searchIdfromArray($response, $apiKey)
    {
        $id_device = null;
        foreach ($response['data'] as $account) {
            if ($account['apiKey'] === $apiKey) {
                $id_device = $account['id'];

                break;
            }
        }

        return $id_device;
    }

    public function deleteDevice($apiKey)
    {
        $response = $this->whatsAppService->listDevice();
        $id = $this->searchIdfromArray($response, $apiKey);
        $response = $this->whatsAppService->deleteDevice($id);
        if (isset($response['status'])) {
            return response()->json(['status' => $response['status'], 'message' => $response['message']]);
        }

        return response()->json(['status' => false, 'message' => 'Error Menghapus Device']);
    }

    public function listDevices()
    {
        $response = $this->whatsAppService->listDevice();

        return response()->json($response);
    }

    public function detailDevice($id_device)
    {
        return $this->whatsAppService->detailDevice($id_device);
    }
}
