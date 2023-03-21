<?php

use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.login.index');
    });

    Route::middleware(['guest'])->group(function () {
        Route::resource('login', LoginController::class)->only('index', 'store');
        Route::resource('forgot-password', ForgotPasswordController::class)->only('index', 'store');
        Route::resource('reset-password', ResetPasswordController::class)->only('show', 'store')->parameters([
            'reset-password' => 'token',
        ]);
    });

    Route::middleware(['auth', 'auth.admin'])->group(function () {
        Route::delete('logout', [LogoutController::class, 'destroy'])->name('logout');
        Route::resource('dashboard', DashboardController::class)->only('index');
    });
});
