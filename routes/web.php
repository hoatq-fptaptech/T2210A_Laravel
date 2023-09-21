<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\HomeController::class,"home"]);
Route::get('/category/{category:slug}', [\App\Http\Controllers\HomeController::class,"category"]);
Route::get("about-us",[\App\Http\Controllers\HomeController::class,"aboutUs"]);
Route::get('/detail/{product:slug}', [\App\Http\Controllers\HomeController::class,"product"]);



