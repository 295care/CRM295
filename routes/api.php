<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\QuotationController;
use App\Http\Controllers\Api\DashboardController;

Route::get('dashboard', [DashboardController::class, 'index']);
Route::apiResource('quotations', QuotationController::class);
Route::apiResource('activities', ActivityController::class);
Route::apiResource('leads', LeadController::class);