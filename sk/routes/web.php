<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin Routes & User Management CRUD
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::get('/users/create', [DashboardController::class, 'createUser'])->name('users.create');
        Route::post('/users', [DashboardController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{id}/edit', [DashboardController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{id}', [DashboardController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [DashboardController::class, 'deleteUser'])->name('users.destroy');
    });

    Route::middleware('role:staff')->get('/staff/dashboard', [DashboardController::class, 'staff'])->name('staff.dashboard');
    Route::middleware('role:customer')->get('/customer/dashboard', [DashboardController::class, 'customer'])->name('customer.dashboard');
});