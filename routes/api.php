<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ShipmentController;
use App\Http\Controllers\Api\TrackingController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\RateController;

// Public routes
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);

// Public tracking (no auth required)
Route::get('track/{awb}', [TrackingController::class, 'publicTrack']);
Route::post('track/bulk', [TrackingController::class, 'bulkTrack']);

// Rate calculator
Route::post('rates/calculate', [RateController::class, 'calculate']);

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/user', [AuthController::class, 'user']);

    // Shipments
    Route::apiResource('shipments', ShipmentController::class);
    Route::post('shipments/{shipment}/track', [TrackingController::class, 'update']);
    Route::post('shipments/bulk-status', [ShipmentController::class, 'bulkStatusUpdate']);
    Route::get('shipments/{shipment}/label', [ShipmentController::class, 'label']);
    Route::post('shipments/bulk-upload', [ShipmentController::class, 'bulkUpload']);

    // Branches (admin only)
    Route::apiResource('branches', BranchController::class);

    // Customers
    Route::apiResource('customers', CustomerController::class);
    Route::get('customers/{customer}/ledger', [CustomerController::class, 'ledger']);
    Route::post('customers/{customer}/ledger', [CustomerController::class, 'addLedgerEntry']);

    // Rates
    Route::apiResource('rates', RateController::class);
});
