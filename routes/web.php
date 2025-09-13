<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('employees', App\Http\Controllers\EmployeeController::class);
Route::resource('time-records', App\Http\Controllers\TimeRecordController::class);
Route::resource('reports', App\Http\Controllers\ReportController::class);
Route::resource('administrators', App\Http\Controllers\AdministratorController::class);
