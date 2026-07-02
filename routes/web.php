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

    // Master Data Management
    Route::resource('vendor-categories', \App\Http\Controllers\Admin\VendorCategoryController::class)->except(['create', 'show', 'edit']);
    Route::resource('timeline-templates', \App\Http\Controllers\Admin\TimelineTemplateController::class)->except(['create', 'show', 'edit']);

    // System Settings
    Route::get('settings', [\App\Http\Controllers\Admin\SystemSettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [\App\Http\Controllers\Admin\SystemSettingController::class, 'update'])->name('settings.update');
});

// Wedding Organizer Panel Routes
Route::middleware(['auth', 'role:wo,wo_team'])->prefix('wo')->name('wo.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\WO\DashboardController::class, 'index'])->name('dashboard');
    
    // Business Profile
    Route::get('/profile', [\App\Http\Controllers\WO\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\WO\ProfileController::class, 'update'])->name('profile.update');
    
    // CRUD Resources (using modals, so we exclude create/show/edit)
    Route::resource('packages', \App\Http\Controllers\WO\PackageController::class)->except(['create', 'show', 'edit']);
    Route::resource('vendors', \App\Http\Controllers\WO\VendorController::class)->except(['create', 'show', 'edit']);
    Route::resource('clients', \App\Http\Controllers\WO\ClientController::class)->except(['create', 'show', 'edit']);
    Route::resource('team', \App\Http\Controllers\WO\TeamController::class)->except(['create', 'show', 'edit']);
    Route::post('projects/{project}/duplicate', [\App\Http\Controllers\WO\WeddingProjectController::class, 'duplicate'])->name('projects.duplicate');
    Route::resource('projects', \App\Http\Controllers\WO\WeddingProjectController::class)->except(['create', 'edit']);
    
    // Project Budget Items
    Route::post('projects/{project}/budget-items', [\App\Http\Controllers\WO\BudgetItemController::class, 'store'])->name('projects.budget-items.store');
    Route::put('projects/{project}/budget-items/{budgetItem}', [\App\Http\Controllers\WO\BudgetItemController::class, 'update'])->name('projects.budget-items.update');
    Route::delete('projects/{project}/budget-items/{budgetItem}', [\App\Http\Controllers\WO\BudgetItemController::class, 'destroy'])->name('projects.budget-items.destroy');
    Route::get('projects/{project}/budget/export-pdf', [\App\Http\Controllers\WO\BudgetItemController::class, 'exportPdf'])->name('projects.budget.export-pdf');
    Route::get('projects/{project}/budget/export-excel', [\App\Http\Controllers\WO\BudgetItemController::class, 'exportExcel'])->name('projects.budget.export-excel');

    // Project Schedule Milestones
    Route::post('projects/{project}/milestones', [\App\Http\Controllers\WO\MilestoneController::class, 'store'])->name('projects.milestones.store');
    Route::put('projects/{project}/milestones/{milestone}', [\App\Http\Controllers\WO\MilestoneController::class, 'update'])->name('projects.milestones.update');
    Route::delete('projects/{project}/milestones/{milestone}', [\App\Http\Controllers\WO\MilestoneController::class, 'destroy'])->name('projects.milestones.destroy');
    Route::post('projects/{project}/milestones/generate', [\App\Http\Controllers\WO\MilestoneController::class, 'generateFromTemplate'])->name('projects.milestones.generate');

    // Project Tasks
    Route::post('projects/{project}/tasks', [\App\Http\Controllers\WO\TaskController::class, 'store'])->name('projects.tasks.store');
    Route::put('projects/{project}/tasks/{task}', [\App\Http\Controllers\WO\TaskController::class, 'update'])->name('projects.tasks.update');
    Route::delete('projects/{project}/tasks/{task}', [\App\Http\Controllers\WO\TaskController::class, 'destroy'])->name('projects.tasks.destroy');

    // Venue Management
    Route::resource('venues', \App\Http\Controllers\WO\VenueController::class)->except(['create', 'show', 'edit']);
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
