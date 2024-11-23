<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrmUserController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\ResponseController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('crm-users', CrmUserController::class);
Route::resource('unit-kerja', UnitKerjaController::class);
Route::resource('responses', ResponseController::class);

