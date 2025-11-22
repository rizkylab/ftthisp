<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FaultLogController;
use App\Http\Controllers\MapController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/map-data', [MapController::class, 'data']);
    
    Route::get('/customers', [CustomerController::class, 'index']);
    Route::get('/customers/{customer}', [CustomerController::class, 'show']);
    
    Route::post('/fault-logs', [FaultLogController::class, 'store']);
    Route::get('/fault-logs', [FaultLogController::class, 'index']);
});
