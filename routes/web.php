<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('employees', App\Http\Controllers\EmployeeController::class);
    Route::resource('time-records', App\Http\Controllers\TimeRecordController::class);
    Route::resource('reports', App\Http\Controllers\ReportController::class);
    Route::resource('administrators', App\Http\Controllers\AdministratorController::class);

    Route::get('/user/password', [UserController::class, 'editPassword'])->name('user.password.edit');
    Route::post('/user/password', [UserController::class, 'updatePassword'])->name('user.password.update');
});
