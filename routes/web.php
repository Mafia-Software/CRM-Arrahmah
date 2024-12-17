<?php

use App\Services\WhatsappService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/test-whatsapp', function (WhatsappService $whatsAppService) {
    $number = '6289523707403'; // Ganti dengan nomor tujuan
    $message = 'tes api wa'; // Ganti dengan pesan yang ingin dikirim
    $type = 'text'; // Ganti dengan pesan yang ingin dikirim
    $instance = '609ACF283XXXX'; // Ganti dengan pesan yang ingin dikirim
    $token = '675d6ed5a0c8d'; // Ganti dengan pesan yang ingin dikirim

    $response = $whatsAppService->sendMessage($number, $message, $type, $instance, $token);

    return response()->json($response);
});