<?php

namespace App\Services;

use GuzzleHttp\Client;

class WhatsAppService
{
    protected $client;
    protected $url;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->url = env('WABLAST_URL');
        $this->apiKey = env('WABLAST_API_KEY');
    }

    public function sendMessage($number, $type, $message, $instance, $token)
    {
        try {
            $response = $this->client->post($this->url, [
                'headers' => [
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'number' => $number,
                    'type' => $type,
                    'message' => $message,
                    'instance_id' => $instance,
                    'access_token' => $token,
                ],
                'verify' => false, // Nonaktifkan verifikasi SSL (untuk testing)
            ]);

            // Periksa status code dan response body
            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents(); // Menangkap body respons

            

            // Menyimpan atau menampilkan status code dan body
            return [
                'status_code' => $statusCode,
                'response_body' => json_decode($body, true), // Parse JSON response
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
        
    }
}
