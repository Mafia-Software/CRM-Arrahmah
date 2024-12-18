<?php

use App\Services\WhatsappService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/test-whatsapp', function (WhatsappService $whatsAppService) {
    $number = request('number'); // Nomor penerima dari Postman
    $type = request('type'); // Tipe pesan dari Postman
    $message = request('message'); // Isi pesan dari Postman
    $instance_id = request('instance_id'); // Instance ID dari Postman
    $token = request('access_token'); // Token akses dari Postman

    $response = $whatsAppService->sendMessage($number, $message, $type, $instance_id, $token);

    return response()->json($response);
});
