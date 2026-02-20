<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ShipmentController;
use App\Http\Controllers\Web\TrackingController;
use App\Http\Controllers\Web\CustomerController;
use App\Http\Controllers\Web\BranchController;
use App\Http\Controllers\Web\RateController;
use App\Http\Controllers\Web\EmployeeController;
use App\Http\Controllers\Web\ReportController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/track', [HomeController::class, 'trackPage'])->name('track.page');
Route::post('/track', [TrackingController::class, 'publicTrack'])->name('track.public');
Route::get('/track/{awb}', [TrackingController::class, 'show'])->name('track.show');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Auth
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Authenticated
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Shipments
    Route::resource('shipments', ShipmentController::class);
    Route::post('shipments/{shipment}/update-status', [ShipmentController::class, 'updateStatus'])->name('shipments.update-status');
    Route::get('shipments/{shipment}/label', [ShipmentController::class, 'label'])->name('shipments.label');
    Route::get('shipments/{shipment}/invoice', [ShipmentController::class, 'invoice'])->name('shipments.invoice');
    Route::post('shipments/bulk-upload', [ShipmentController::class, 'bulkUpload'])->name('shipments.bulk-upload');

    // Customers
    Route::resource('customers', CustomerController::class);
    Route::get('customers/{customer}/ledger', [CustomerController::class, 'ledger'])->name('customers.ledger');

    // Branches (admin)
    Route::resource('branches', BranchController::class);

    // Rates
    Route::resource('rates', RateController::class);

    // Employees & HRMS
    Route::resource('employees', EmployeeController::class);

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/shipments', [ReportController::class, 'shipments'])->name('reports.shipments');
    Route::get('/reports/customers', [ReportController::class, 'customers'])->name('reports.customers');
    Route::get('/reports/employees', [ReportController::class, 'employees'])->name('reports.employees');
});

// Public branches and rates pages - defined after resources to win URL resolution
Route::get('/branches', [HomeController::class, 'branches'])->name('public.branches');
Route::get('/rates', [HomeController::class, 'rates'])->name('rates.public');
