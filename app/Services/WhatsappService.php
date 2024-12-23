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

    public function sendMessage($number, $message, $instance_id)
    {
        $url = 'https://new.sentwa.com/api/send.php';

        $response = Http::withOptions([
            "verify" => false,
        ])->get($url, [
            'number' => $number,
            'type' => 'text',
            'message' => $message,
            'instance_id' => $instance_id,
            'access_token' => $this->accessToken
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
    public function getQR($instance_id)
    {
        $url = 'https://new.sentwa.com/api/get_qr.php';

        $response = Http::withOptions([
            "verify" => false,
        ])->get($url, [
            'instance_id' => $instance_id,
            'access_token' => $this->accessToken
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
}
