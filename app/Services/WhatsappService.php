<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

// use GuzzleHttp\Client;

class WhatsAppService
{
    // protected $instance_id;
    // protected $accessToken;

    // public function __construct()
    // {

    //     $this->instance_id = env('WABLAST_INSTANCE_ID');
    //     $this->accessToken = env('WABLAST_API_KEY');
    // }

    public function sendMessage($number, $type, $message, $instance_id, $token)
    {
        $url = 'https://new.sentwa.com/api/send.php';

        $response = Http::withOptions([
            "verify" => false,
        ])->get($url, [
            'number' => $number,
            'type' => $type,
            'message' => $message,
            'instance_id' => $instance_id,
            'access_token' => $token
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
