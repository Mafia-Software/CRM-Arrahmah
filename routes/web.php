<?php

use App\Services\WhatsappService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\WhatsappController;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/test-whatsapp', [WhatsappController::class, 'send']);