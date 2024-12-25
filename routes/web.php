<?php

use App\Services\WhatsappService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Controllers\API\WhatsappController;
use App\Http\Controllers\WhatsAppServerController;

Route::get('/', function () {
    return redirect('/admin');
});

Route::post('/sendMessage', [WhatsappController::class, 'send']);


Route::post('/create-wa-server', [WhatsAppServerController::class, 'createwaserver']);
