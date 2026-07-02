<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Central Dashboard Route (Redirects based on role)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Super Admin Panel Routes
Route::middleware(['auth', 'role:super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', \App\Http\Controllers\Admin\DashboardController::class)->name('dashboard');
    
    // WO Management
    Route::resource('wo', \App\Http\Controllers\Admin\WoController::class)->except(['create', 'store', 'edit', 'update']);
    Route::patch('wo/{wo}/toggle-status', [\App\Http\Controllers\Admin\WoController::class, 'toggleStatus'])->name('wo.toggle-status');

    // Subscription & Billing Management
    Route::resource('subscriptions', \App\Http\Controllers\Admin\SubscriptionController::class)->only(['index', 'show']);
    Route::patch('subscriptions/{subscription}/approve', [\App\Http\Controllers\Admin\SubscriptionController::class, 'approve'])->name('subscriptions.approve');
    Route::patch('subscriptions/{subscription}/reject', [\App\Http\Controllers\Admin\SubscriptionController::class, 'reject'])->name('subscriptions.reject');
});

// Wedding Organizer Panel Routes
Route::middleware(['auth', 'role:wo'])->prefix('wo')->name('wo.')->group(function () {
    Route::get('/dashboard', function () {
        return view('wo.dashboard');
    })->name('dashboard');
});

// Client Panel Routes
Route::middleware(['auth', 'role:client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', function () {
        return view('client.dashboard');
    })->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
