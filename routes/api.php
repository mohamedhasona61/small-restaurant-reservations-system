<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TableController;

Route::apiResource('table', TableController::class);
Route::post('tables/check-availability', [TableController::class, 'checkAvailability']);
Route::post('table/{id}/restore', [TableController::class, 'restore']);
