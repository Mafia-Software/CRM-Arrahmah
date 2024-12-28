<?php

namespace App\Services;

use App\Models\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class WhatsappService
{
    protected $wa_api;
    protected $telegram_token;
    protected $wa_endpoint;
    protected $webhook_url;

    public function __construct()
    {
        $this->wa_api = Config::get('custom.wa_api');
        $this->telegram_token = Config::get('custom.telegram_token');
        $this->wa_endpoint = Config::get('custom.wa_endpoint');
        $this->webhook_url = Config::get('custom.webhook_url');
    }

    public function sendMessage($apiKey, $number, $message)
    {
        $url = $this->wa_endpoint . 'sendMessage';

        $response = Http::withOptions([
            "verify" => false,
        ])->post($url, [
            'apiKey' => $apiKey,
            'phone' => $number,
            'message' => $message,
        ]);

        Log::create([
            'type' => 'api_return',
            'logs' => $response->body()
        ]);
        return $response->json();
    }

    public function sendBulkMessage($apiKey, $number, $message)
    {
        $url =  $this->wa_endpoint . 'sendBulkMessage';

        $response = Http::withOptions([
            "verify" => false,
        ])->post($url, [
            'apiKey' => $apiKey,
            'phone' => $number,
            'message' => $message,
        ]);
        Log::create([
            'type' => 'api_return',
            'logs' => $response->body()
        ]);
        return $response->json();
    }
    public function getQR($apiKey)
    {
        $url =  $this->wa_endpoint . 'getQR';

        $response = Http::withOptions([
            "verify" => false,
        ])->get($url, [
            'apiKey' => $apiKey
        ]);
        Log::create([
            'type' => 'api_return',
            'logs' => $response->body()
        ]);
        return $response->json();
    }

    public function sendMediaFromUrl($apiKey, $number, $url_file, $as_document)
    {
        $url =  $this->wa_endpoint . 'sendMediaFromUrl';

        $response = Http::withOptions([
            "verify" => false,
        ])->post($url, [
            'apiKey' => $apiKey,
            'phone' => $number,
            'url_file' => $url_file,
            'as_document' => $as_document,
        ]);
        Log::create([
            'type' => 'api_return',
            'logs' => $response->body()
        ]);
        return $response->json();
    }

    public function addDevice($apiKey, $number, $name_device)
    {
        $url =  $this->wa_endpoint . 'addDevice';

        $response = Http::post($url, [
            'secret' => $this->wa_api,
            'name' => $name_device,
            'apiKey' => $apiKey,
            'pair_method' => 'qr',
            'number_hp' => $number,
            'tele_id' => $this->telegram_token,
            'webhook_url' => $this->webhook_url,
            'webhook_status' => 1,
            'restoresession_status' => 1,
            'webhook_media_status' => 1,
            'autostart_status' => 1
        ]);

        Log::create([
            'type' => 'api_return',
            'logs' => $response->body()
        ]);
        return $response->json();
    }

    public function editDevice($number, $name_device)
    {
        $url =  $this->wa_endpoint . 'editDevice';

        $response = Http::post($url, [
            'secret' => $this->wa_api,
            'name' => $name_device,
            'pair_method' => 'qr',
            'number_hp' => $number,
            'tele_id' => $this->telegram_token,
            'webhook_url' => $this->webhook_url,
            'webhook_status' => 1,
            'restoresession_status' => 1,
            'webhook_media_status' => 1,
            'autostart_status' => 1
        ]);

        Log::create([
            'type' => 'api_return',
            'logs' => $response->body()
        ]);
        return $response->json();
    }
    public function deleteDevice($id_device)
    {
        $url = $this->wa_endpoint . 'deleteDevice';
        $response = Http::withOptions([
            "verify" => false,
        ])->post($url, [
            'secret' => $this->wa_api,
            'id' => $id_device
        ]);
        Log::create([
            'type' => 'api_return',
            'logs' => $response->body()
        ]);
        return $response->json();
    }
    public function listDevice()
    {
        $url = $this->wa_endpoint . 'listDevice';
        $client = new Client();
        $request = new Request('GET', $url);
        $response = $client->sendAsync($request, [
            'form_params' => [
                'secret' => $this->wa_api
            ]
        ])->wait();
        Log::create([
            'type' => 'api_return',
            'logs' => $response->getBody()
        ]);
        return json_decode($response->getBody(), true);
    }
    public function detailDevice($id_device)
    {
        $url = $this->wa_endpoint . 'detailDevice';

        $response = Http::withOptions([
            "verify" => false,
        ])->post($url, [
            'secret' => $this->wa_api,
            'id' => $id_device,

        ]);
        Log::create([
            'type' => 'api_return',
            'logs' => $response->body()
        ]);
        return $response->json();
    }

    public function getState($apiKey)
    {
        $url = $this->wa_endpoint . 'getState';

        $response = Http::withOptions([
            "verify" => false,
        ])->get($url, [
            'apiKey' => $apiKey
        ]);
        Log::create([
            'type' => 'api_return',
            'logs' => $response->body()
        ]);
        return $response->json();
    }
    public function startService($apiKey)
    {
        $url = $this->wa_endpoint . 'serviceStart';

        $response = Http::withOptions([
            "verify" => false,
        ])->get($url, [
            'apiKey' => $apiKey
        ]);
        Log::create([
            'type' => 'api_return',
            'logs' => $response->body()
        ]);
        return $response->json();
    }

    public function stopService($apiKey)
    {
        $url = $this->wa_endpoint . 'serviceDestroy';

        $response = Http::withOptions([
            "verify" => false,
        ])->get($url, [
            'apiKey' => $apiKey
        ]);
        Log::create([
            'type' => 'api_return',
            'logs' => $response->body()
        ]);
        return $response->json();
    }


    // public function createInstance()
    // {
    //     $url = 'https://new.sentwa.com/api/createinstance.php';

    //     $response = Http::withOptions([
    //         "verify" => false,
    //     ])->get($url, [
    //         'access_token' => $this->wa_api
    //     ]);

    //     // Memeriksa status dan respons
    //     if ($response->successful()) {
    //         // Jika berhasil, mengembalikan respons JSON
    //         return $response->json();
    //     } else {
    //         // Jika gagal, mengembalikan status dan pesan error
    //         return [
    //             'status' => $response->status(),
    //             'error' => $response->body()
    //         ];
    //     }
    // }
}
