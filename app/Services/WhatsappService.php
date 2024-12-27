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

    public function sendMessage($number, $message)
    {
        $url = 'http://waapi.domcloud.dev/api/sendMessage';

        $response = Http::withOptions([
            "verify" => false,
        ])->post($url, [
            'apiKey' => $this->accessToken,
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
        $url = 'http://waapi.domcloud.dev/api/sendBulkMessage';

        $response = Http::withOptions([
            "verify" => false,
        ])->post($url, [
            'apiKey' => $this->accessToken,
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
        $url = 'http://waapi.domcloud.dev/api/getQR';

        $response = Http::withOptions([
            "verify" => false,
        ])->get($url, [
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

    public function sendMediaFromUrl($number, $url_file, $as_document)
    {
        $url = 'http://waapi.domcloud.dev/api/sendMediaFromUrl';

        $response = Http::withOptions([
            "verify" => false,
        ])->post($url, [
            'apiKey' => $this->accessToken,
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

    public function addDevice($number, $name_device, $pair, $tele_id)
    {
        $url = 'http://waapi.domcloud.dev/api/addDevice';

        $response = Http::withOptions([
            "verify" => false,
        ])->post($url, [
            'secret' => $this->accessToken,
            'name' => $name_device,
            'pair_method' => $pair,
            'number_hp' => $number,
            'tele_id' => $tele_id,
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

    public function editDevice($number, $name_device, $pair, $tele_id)
    {
        $url = 'http://waapi.domcloud.dev/api/editDevice';

        $response = Http::withOptions([
            "verify" => false,
        ])->post($url, [
            'secret' => $this->accessToken,
            'name' => $name_device,
            'pair_method' => $pair,
            'number_hp' => $number,
            'tele_id' => $tele_id,
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
            'secret' => $this->accessToken,
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
