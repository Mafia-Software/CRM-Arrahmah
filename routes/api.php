<?php

use Illuminate\Support\Facades\Route;

Route::prefix('wa')->group(function () {
    Route::post('/sendMessage', [App\Http\Controllers\API\WhatsappController::class, 'send']);
});
