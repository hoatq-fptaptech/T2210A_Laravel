<?php
Route::get("/dashboard", [\App\Http\Controllers\AdminController::class, "dashboard"]);
Route::get("/category", [\App\Http\Controllers\AdminController::class, "dashboard"]);
Route::get("/product", [\App\Http\Controllers\AdminController::class, "dashboard"]);
Route::get("/order", [\App\Http\Controllers\AdminController::class, "orders"]);
