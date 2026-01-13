<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TranscriptController;

/*
|--------------------------------------------------------------------------
| API Routes - مسارات الـ API
| Team 404 - Examination & Grades System
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Api\AuthController;

// API v1
Route::prefix('v1')->group(function () {

    // Public Routes - مسارات عامة
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Protected Routes - مسارات محمية
    Route::middleware('auth:sanctum')->group(function () {
        // Transcript API - السجل الأكاديمي
        Route::get('/transcript/{student_id}', [TranscriptController::class, 'show'])
            ->where('student_id', '[0-9]+');
    });
});

