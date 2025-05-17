<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RideController;

Route::get('/', [RideController::class, 'showForm']);
Route::post('/lookup', [RideController::class, 'lookup']);
