<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

// use GuzzleHttp\Client;

class WhatsappService
{
    protected $accessToken;

    public function __construct()
    {
        $this->accessToken = Config::get('custom.wa_token');
    }

    public function sendMessage($phone, $message)
    {
        $url = 'http://localhost:3000/api/sendMessage';

        $response = Http::withOptions([
            "verify" => false,
        ])->get($url, [
            'apiKey' => $this->accessToken,
            'number' => $phone,
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
    public function getQR()
    {
        $url = 'http://localhost:3000/api/getQR';

        $response = Http::withOptions([
            "verify" => false,
        ])->get($url, [
            // 'instance_id' => $instance_id,
            'apiKey' => $this->accessToken
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
    //         'access_token' => $this->accessToken
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
