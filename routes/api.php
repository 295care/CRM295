<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\QuotationController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ReportController;

Route::name('api.')->middleware('auth:sanctum')->group(function () {
	Route::get('dashboard', [DashboardController::class, 'index']);
	Route::get('reports/summary', [ReportController::class, 'summary']);
	Route::get('reports/sales-monthly', [ReportController::class, 'salesMonthly']);
	Route::get('reports/funnel-conversion', [ReportController::class, 'funnelConversion']);
	Route::get('reports/followups-health', [ReportController::class, 'followupsHealth']);
	Route::apiResource('quotations', QuotationController::class);
	Route::apiResource('activities', ActivityController::class);
	Route::apiResource('leads', LeadController::class);
});