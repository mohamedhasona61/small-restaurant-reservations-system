<?php

use App\Http\Controllers\Api\MenuCategoryController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\ReseravationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TableController;

// Tables
Route::apiResource('table', TableController::class);
Route::post('tables/check-availability', [TableController::class, 'checkAvailability']);
Route::post('table/{id}/restore', [TableController::class, 'restore']);

// Menu Category
Route::apiResource('menu-category', MenuCategoryController::class);


// Menus 
Route::apiResource('menus', MenuController::class);

Route::get('menus/get-available-menu-items', [MenuController::class, 'getAvailableMenuItems']);

Route::post('create-reseravation', [ReseravationController::class, 'createOrder']);
