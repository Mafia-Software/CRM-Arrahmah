<?php

namespace App\Services;

use App\Models\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

// use GuzzleHttp\Client;

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

<<<<<<< HEAD
    public function sendMessage($phone, $message)
    {
        $url = 'http://localhost:3000/api/sendMessage';

        $response = Http::withOptions([
            "verify" => false,
        ])->get($url, [
            'apiKey' => $this->accessToken,
            'number' => $phone,
=======
    public function sendMessage($apiKey, $number, $message)
    {
        $url = $this->wa_endpoint . 'sendMessage';

        $response = Http::withOptions([
            "verify" => false,
        ])->post($url, [
            'apiKey' => $apiKey,
            'phone' => $number,
>>>>>>> b01659fe1f5a138196f843b908b1420c47105e10
            'message' => $message,
        ]);

        // Memeriksa status dan respons
        if ($response->successful()) {
            Log::create([
                'type' => 'api_return',
                'logs' => $response->body()
            ]);
            // Jika berhasil, mengembalikan respons JSON
            return $response->json();
        } else {
            Log::create([
                'type' => 'api_return',
                'logs' => $response->body()
            ]);
            // Jika gagal, mengembalikan status dan pesan error
            return [
                'status' => $response->status(),
                'msg' => $response->body()
            ];
        }
    }
<<<<<<< HEAD
    public function getQR()
    {
        $url = 'http://localhost:3000/api/getQR';
=======

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
        // Memeriksa status dan respons
        if ($response->successful()) {
            Log::create([
                'type' => 'api_return',
                'logs' => $response->body()
            ]);
            // Jika berhasil, mengembalikan respons JSON
            return $response->json();
        } else {
            Log::create([
                'type' => 'api_return',
                'logs' => $response->body()
            ]);
            // Jika gagal, mengembalikan status dan pesan error
            return [
                'status' => $response->status(),
                'msg' => $response->body()
            ];
        }
    }
    public function getQR($apiKey)
    {
        $url =  $this->wa_endpoint.'getQR';
>>>>>>> b01659fe1f5a138196f843b908b1420c47105e10

        $response = Http::withOptions([
            "verify" => false,
        ])->get($url, [
<<<<<<< HEAD
            // 'instance_id' => $instance_id,
            'apiKey' => $this->accessToken
=======
            'apiKey' => $apiKey
>>>>>>> b01659fe1f5a138196f843b908b1420c47105e10
        ]);

        // Memeriksa status dan respons
        if ($response->successful()) {
            // Jika berhasil, mengembalikan respons JSON
            Log::create([
                'type' => 'api_return',
                'logs' => $response->body()
            ]);
            return $response->json();
        } else {
            Log::create([
                'type' => 'api_return',
                'logs' => $response->body()
            ]);
            // Jika gagal, mengembalikan status dan pesan error
            return [
                'status' => $response->status(),
                'msg' => $response->body()
            ];
        }
    }
<<<<<<< HEAD
    // public function createInstance()
    // {
    //     $url = 'https://new.sentwa.com/api/createinstance.php';

    //     $response = Http::withOptions([
    //         "verify" => false,
    //     ])->get($url, [
    //         'access_token' => $this->accessToken
    //     ]);

=======

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

        // Memeriksa status dan respons
        if ($response->successful()) {
            Log::create([
                'type' => 'api_return',
                'logs' => $response->body()
            ]);
            // Jika berhasil, mengembalikan respons JSON
            return $response->json();
        } else {
            Log::create([
                'type' => 'api_return',
                'logs' => $response->body()
            ]);
            // Jika gagal, mengembalikan status dan pesan error
            return [
                'status' => $response->status(),
                'msg' => $response->body()
            ];
        }
    }

    public function addDevice($apiKey, $number, $name_device)
    {
        $url =  $this->wa_endpoint . 'addDevice';

        $response = Http::withOptions([
            "verify" => false,
        ])->post($url, [
            'secret' => $this->wa_api,
            'name' => $name_device,
            'apiKey' => $apiKey,
            'pair_method' => 'qr',
            'number_hp' => $number,
            'tele_id' => $this->telegram_token,
            'webhook_url' => $this->webhook_url
        ]);

        // Memeriksa status dan respons
        if ($response->successful()) {
            Log::create([
                'type' => 'api_return',
                'logs' => $response->body()
            ]);
            // Jika berhasil, mengembalikan respons JSON
            return $response->json();
        } else {
            Log::create([
                'type' => 'api_return',
                'logs' => $response->body()
            ]);
            // Jika gagal, mengembalikan status dan pesan error
            return [
                'status' => $response->status(),
                'msg' => $response->body()
            ];
        }
    }

    public function editDevice($number, $name_device)
    {
        $url =  $this->wa_endpoint . 'editDevice';

        $response = Http::withOptions([
            "verify" => false,
        ])->post($url, [
            'secret' => $this->wa_api,
            'name' => $name_device,
            'pair_method' => 'qr',
            'number_hp' => $number,
            'tele_id' => $this->telegram_token,
            'webhook_url' => $this->webhook_url
        ]);

        // Memeriksa status dan respons
        if ($response->successful()) {
            Log::create([
                'type' => 'api_return',
                'logs' => $response->body()
            ]);
            // Jika berhasil, mengembalikan respons JSON
            return $response->json();
        } else {
            Log::create([
                'type' => 'api_return',
                'logs' => $response->body()
            ]);
            // Jika gagal, mengembalikan status dan pesan error
            return [
                'status' => $response->status(),
                'msg' => $response->body()
            ];
        }
    }

    public function detailDevice($id_device)
    {
        $url = $this->wa_endpoint . 'editDevice';

        $response = Http::withOptions([
            "verify" => false,
        ])->post($url, [
            'secret' => $this->wa_api,
            'id' => $id_device,

        ]);

        // Memeriksa status dan respons
        if ($response->successful()) {
            Log::create([
                'type' => 'api_return',
                'logs' => $response->body()
            ]);
            // Jika berhasil, mengembalikan respons JSON
            return $response->json();
        } else {
            Log::create([
                'type' => 'api_return',
                'logs' => $response->body()
            ]);
            // Jika gagal, mengembalikan status dan pesan error
            return [
                'status' => $response->status(),
                'msg' => $response->body()
            ];
        }
    }

    public function getState($apiKey)
    {
        $url = $this->wa_endpoint . 'getState';

        $response = Http::withOptions([
            "verify" => false,
        ])->get($url, [
            'apiKey' => $apiKey
        ]);

        // Memeriksa status dan respons
        if ($response->successful()) {
            // Jika berhasil, mengembalikan respons JSON
            return $response->json();
        } else {

            // Jika gagal, mengembalikan status dan pesan error
            return [
                'status' => $response->status(),
                'msg' => $response->body()
            ];
        }
    }
    public function startService($apiKey)
    {
        $url = $this->wa_endpoint . 'serviceStart';

        $response = Http::withOptions([
            "verify" => false,
        ])->get($url, [
            'apiKey' => $apiKey
        ]);

        // Memeriksa status dan respons
        if ($response->successful()) {
            Log::create([
                'type' => 'api_return',
                'logs' => $response->body()
            ]);
            // Jika berhasil, mengembalikan respons JSON
            return $response->json();
        } else {
            Log::create([
                'type' => 'api_return',
                'logs' => $response->body()
            ]);
            // Jika gagal, mengembalikan status dan pesan error
            return [
                'status' => $response->status(),
                'msg' => $response->body()
            ];
        }
    }

    public function stopService($apiKey)
    {
        $url = $this->wa_endpoint . 'serviceDestroy';

        $response = Http::withOptions([
            "verify" => false,
        ])->get($url, [
            'apiKey' => $apiKey
        ]);

        // Memeriksa status dan respons
        if ($response->successful()) {
            Log::create([
                'type' => 'api_return',
                'logs' => $response->body()
            ]);
            // Jika berhasil, mengembalikan respons JSON
            return $response->json();
        } else {
            Log::create([
                'type' => 'api_return',
                'logs' => $response->body()
            ]);
            // Jika gagal, mengembalikan status dan pesan error
            return [
                'status' => $response->status(),
                'msg' => $response->body()
            ];
        }
    }


    // public function createInstance()
    // {
    //     $url = 'https://new.sentwa.com/api/createinstance.php';

    //     $response = Http::withOptions([
    //         "verify" => false,
    //     ])->get($url, [
    //         'access_token' => $this->wa_api
    //     ]);

>>>>>>> b01659fe1f5a138196f843b908b1420c47105e10
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
