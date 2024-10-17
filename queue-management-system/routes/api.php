<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BusinessHoursController;
use App\Http\Controllers\WaitingListController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/user', [AuthController::class, 'updateProfile']);

    // Services
    Route::apiResource('services', ServiceController::class);

    // Appointments
    Route::apiResource('appointments', AppointmentController::class);

    // Business Hours
    Route::get('/business-hours', [BusinessHoursController::class, 'index']);
    Route::post('/business-hours', [BusinessHoursController::class, 'store']);
    Route::put('/business-hours/{businessHours}', [BusinessHoursController::class, 'update']);
    Route::delete('/business-hours/{businessHours}', [BusinessHoursController::class, 'destroy']);

    // Waiting List
    Route::apiResource('waiting-list', WaitingListController::class);

    // Reports
    Route::get('/reports/service-stats', [ReportController::class, 'getServiceStats']);
    Route::get('/reports/appointment-stats', [ReportController::class, 'getAppointmentStats']);
    Route::get('/reports/revenue-stats', [ReportController::class, 'getRevenueStats']);
});