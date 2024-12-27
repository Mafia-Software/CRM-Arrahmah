<?php

namespace App\Services;

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

    public function sendMessage($number, $message)
    {
        $url = $this->wa_endpoint.'sendMessage';

        $response = Http::withOptions([
            "verify" => false,
        ])->post($url, [
            'apiKey' => $this->wa_api,
            'phone' => $number,
            'message' => $message,
        ]);

        // Memeriksa status dan respons
        if ($response->successful()) {
            // Jika berhasil, mengembalikan respons JSON
            return $response->json();
        } else {
            // Jika gagal, mengembalikan status dan pesan error
            return [
                'status' => $response->status(),
                'error' => $response->body()
            ];
        }
    }

    public function sendBulkMessage($number, $message, $delay)
    {
        $url =  $this->wa_endpoint.'sendBulkMessage';

        $response = Http::withOptions([
            "verify" => false,
        ])->post($url, [
            'apiKey' => $this->wa_api,
            'phone' => $number,
            'message' => $message,
            'delay' => $delay,
        ]);

        // Memeriksa status dan respons
        if ($response->successful()) {
            // Jika berhasil, mengembalikan respons JSON
            return $response->json();
        } else {
            // Jika gagal, mengembalikan status dan pesan error
            return [
                'status' => $response->status(),
                'error' => $response->body()
            ];
        }
    }
    public function getQR()
    {
        $url =  $this->wa_endpoint.'getQR';

        $response = Http::withOptions([
            "verify" => false,
        ])->get($url, [
            'apiKey' => $this->wa_api
        ]);

        // Memeriksa status dan respons
        if ($response->successful()) {
            // Jika berhasil, mengembalikan respons JSON
            return $response->json();
        } else {
            // Jika gagal, mengembalikan status dan pesan error
            return [
                'status' => $response->status(),
                'error' => $response->body()
            ];
        }
    }

    public function sendMediaFromUrl($number, $url_file, $as_document)
    {
        $url =  $this->wa_endpoint.'sendMediaFromUrl';

        $response = Http::withOptions([
            "verify" => false,
        ])->post($url, [
            'apiKey' => $this->wa_api,
            'phone' => $number,
            'url_file' => $url_file,
            'as_document' => $as_document,
        ]);

        // Memeriksa status dan respons
        if ($response->successful()) {
            // Jika berhasil, mengembalikan respons JSON
            return $response->json();
        } else {
            // Jika gagal, mengembalikan status dan pesan error
            return [
                'status' => $response->status(),
                'error' => $response->body()
            ];
        }
    }

    public function addDevice($number, $name_device)
    {
        $url =  $this->wa_endpoint.'addDevice';

        $response = Http::withOptions([
            "verify" => false,
        ])->post($url, [
            'secret' => $this->wa_api,
            'name' => $name_device,
            'pair_method' => 1,
            'number_hp' => $number,
            'tele_id' => $this->telegram_token,
            'webhook_url' => $this->webhook_url
        ]);

        // Memeriksa status dan respons
        if ($response->successful()) {
            // Jika berhasil, mengembalikan respons JSON
            return $response->json();
        } else {
            // Jika gagal, mengembalikan status dan pesan error
            return [
                'status' => $response->status(),
                'error' => $response->body()
            ];
        }
    }

    public function editDevice($number, $name_device)
    {
        $url =  $this->wa_endpoint.'editDevice';

        $response = Http::withOptions([
            "verify" => false,
        ])->post($url, [
            'secret' => $this->wa_api,
            'name' => $name_device,
            'pair_method' => 1,
            'number_hp' => $number,
            'tele_id' => $this->telegram_token,
            'webhook_url' => $this->webhook_url
        ]);

        // Memeriksa status dan respons
        if ($response->successful()) {
            // Jika berhasil, mengembalikan respons JSON
            return $response->json();
        } else {
            // Jika gagal, mengembalikan status dan pesan error
            return [
                'status' => $response->status(),
                'error' => $response->body()
            ];
        }
    }

    public function detailDevice($id_device)
    {
        $url = 'http://waapi.domcloud.dev/api/editDevice';

        $response = Http::withOptions([
            "verify" => false,
        ])->post($url, [
            'secret' => $this->wa_api,
            'id' => $id_device,

        ]);

        // Memeriksa status dan respons
        if ($response->successful()) {
            // Jika berhasil, mengembalikan respons JSON
            return $response->json();
        } else {
            // Jika gagal, mengembalikan status dan pesan error
            return [
                'status' => $response->status(),
                'error' => $response->body()
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
