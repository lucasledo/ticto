<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureAdmin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::post('/login', function (Request $request) {
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Credenciais inválidas'], 401);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user'  => $user,
    ]);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::middleware([EnsureAdmin::class])->group(function () {
        Route::resource('employees', App\Http\Controllers\EmployeeController::class);
        Route::resource('reports', App\Http\Controllers\ReportController::class);
        Route::resource('administrators', App\Http\Controllers\AdministratorController::class);
    });

    Route::resource('time-records', App\Http\Controllers\TimeRecordController::class);
    Route::get('/user/password', [UserController::class, 'editPassword'])->name('user.password.edit');
    Route::post('/user/password', [UserController::class, 'updatePassword'])->name('user.password.update');

    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    })->name('logout');
});
