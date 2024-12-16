<?php

use Illuminate\Support\Facades\Route;

Route::prefix('wa')->group(function () {
    Route::get('/sendMessage', [App\Http\Controllers\API\WhatsappController::class, 'sendMessage']);
    Route::get('/setWebhook', [App\Http\Controllers\API\WhatsappController::class, 'setWebhook']);
    Route::get('/sendMedia', [App\Http\Controllers\API\WhatsappController::class, 'sendMedia']);
    Route::get('/createInstance', [App\Http\Controllers\API\WhatsappController::class, 'createInstance']);
});
