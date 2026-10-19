<?php

use App\Http\Controllers\Api\RpcScanController;
use App\Http\Controllers\Api\ScannerAuthController;
use App\Http\Middleware\EnsureScannerToken;
use Illuminate\Support\Facades\Route;

Route::prefix('scanner')->group(function () {
    Route::post('/login', [ScannerAuthController::class, 'login'])->middleware('throttle:5,1');

    Route::middleware(['auth:sanctum', EnsureScannerToken::class])->group(function () {
        Route::post('/logout', [ScannerAuthController::class, 'logout']);
        Route::post('/scan', [RpcScanController::class, 'scan']);
    });
});
