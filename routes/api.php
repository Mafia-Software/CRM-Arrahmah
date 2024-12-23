<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::prefix('wa')->group(function () {
    Route::post('/sendMessage', [App\Http\Controllers\API\WhatsappController::class, 'send']);
});
