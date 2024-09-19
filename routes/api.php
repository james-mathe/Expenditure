<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\ExpenditureController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource("/expenditure",ExpenditureController::class);
Route::apiResource("/category",categoryController::class);

// fro authentication

Route::post("Auth/register", [AuthController::class,"register"]);
Route::post("Auth/login", [AuthController::class,"login"]);
Route::post("Auth/logout", [AuthController::class,"logout"])->middleware('auth:sanctum');