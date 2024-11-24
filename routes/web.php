<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrmUserController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\ResponseController;

Route::get('/', function () {
    return redirect('/admin');
});
