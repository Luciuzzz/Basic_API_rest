<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Session\Middleware\StartSession;

Route::middleware([
    EncryptCookies::class,
    AddQueuedCookiesToResponse::class,
    StartSession::class,
])->group(function () {
    Route::post('admins/login', [AdminController::class, 'login']);
    Route::post('admins/logout', [AdminController::class, 'logout'])->middleware('admin.session');

    Route::apiResource('admins', AdminController::class)->only(['index', 'show']);
    Route::apiResource('admins', AdminController::class)
        ->only(['store', 'update', 'destroy'])
        ->middleware('admin.session');
});

// Route::prefix('admins')->group(function () {
//         Route::post('/', [AdminController::class, 'store']);
//     });

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
