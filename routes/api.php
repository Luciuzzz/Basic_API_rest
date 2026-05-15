<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::apiResource('admins', AdminController::class);

// Route::prefix('admins')->group(function () {
//         Route::post('/', [AdminController::class, 'store']);
//     });

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
