<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GradeController;

Route::get('/', function () {
    return view('welcome');
});

// AJAX: Check existing grade (must be before resource routes)
Route::get('grades/check-existing', [GradeController::class, 'checkExisting'])
    ->name('grades.check-existing');

// Grade routes - مسارات الدرجات
Route::resource('grades', GradeController::class);
