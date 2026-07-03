<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $plans = \App\Models\Plan::orderBy('price', 'asc')->get();
    return view('welcome', compact('plans'));
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
    Route::resource('plans', \App\Http\Controllers\Admin\PlanController::class)->except(['show']);

    // Master Data Management
    Route::resource('vendor-categories', \App\Http\Controllers\Admin\VendorCategoryController::class)->except(['create', 'show', 'edit']);
    Route::resource('timeline-templates', \App\Http\Controllers\Admin\TimelineTemplateController::class)->except(['create', 'show', 'edit']);

    // System Settings
    Route::get('settings', [\App\Http\Controllers\Admin\SystemSettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [\App\Http\Controllers\Admin\SystemSettingController::class, 'update'])->name('settings.update');
});

// Wedding Organizer Panel Routes
Route::middleware(['auth', 'role:wo,wo_team', 'subscription'])->prefix('wo')->name('wo.')->group(function () {
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

    // Project Guest List
    Route::post('projects/{project}/guests', [\App\Http\Controllers\WO\GuestListController::class, 'store'])->name('projects.guests.store');
    Route::put('projects/{project}/guests/{guest}', [\App\Http\Controllers\WO\GuestListController::class, 'update'])->name('projects.guests.update');
    Route::delete('projects/{project}/guests/{guest}', [\App\Http\Controllers\WO\GuestListController::class, 'destroy'])->name('projects.guests.destroy');
    Route::post('projects/{project}/guests/import', [\App\Http\Controllers\WO\GuestListController::class, 'importCsv'])->name('projects.guests.import');
    Route::get('projects/{project}/guests/export', [\App\Http\Controllers\WO\GuestListController::class, 'exportCsv'])->name('projects.guests.export');

    // Project Rundown Management
    Route::post('projects/{project}/rundown', [\App\Http\Controllers\WO\RundownController::class, 'store'])->name('projects.rundown.store');
    Route::put('projects/{project}/rundown/{rundown}', [\App\Http\Controllers\WO\RundownController::class, 'update'])->name('projects.rundown.update');
    Route::delete('projects/{project}/rundown/{rundown}', [\App\Http\Controllers\WO\RundownController::class, 'destroy'])->name('projects.rundown.destroy');
    Route::post('projects/{project}/rundown/generate', [\App\Http\Controllers\WO\RundownController::class, 'generateTemplate'])->name('projects.rundown.generate');
    Route::get('projects/{project}/rundown/print', [\App\Http\Controllers\WO\RundownController::class, 'print'])->name('projects.rundown.print');

    // Project Checklist Management
    Route::post('projects/{project}/checklists', [\App\Http\Controllers\WO\ChecklistController::class, 'store'])->name('projects.checklists.store');
    Route::put('projects/{project}/checklists/{checklist}', [\App\Http\Controllers\WO\ChecklistController::class, 'update'])->name('projects.checklists.update');
    Route::delete('projects/{project}/checklists/{checklist}', [\App\Http\Controllers\WO\ChecklistController::class, 'destroy'])->name('projects.checklists.destroy');
    Route::patch('projects/{project}/checklists/{checklist}/toggle', [\App\Http\Controllers\WO\ChecklistController::class, 'toggleStatus'])->name('projects.checklists.toggle');
    Route::post('projects/{project}/checklists/generate', [\App\Http\Controllers\WO\ChecklistController::class, 'generateTemplate'])->name('projects.checklists.generate');

    // Project Notes & Chat
    Route::post('projects/{project}/notes', [\App\Http\Controllers\WO\WeddingProjectController::class, 'storeNote'])->name('projects.notes.store');

    // Venue Management
    Route::get('venues/{venue}/availability', [\App\Http\Controllers\WO\VenueController::class, 'availability'])->name('venues.availability');
    Route::resource('venues', \App\Http\Controllers\WO\VenueController::class)->except(['create', 'show', 'edit']);

    // Landing Page Customization
    Route::get('landing-page', [\App\Http\Controllers\WO\LandingPageController::class, 'edit'])->name('landing_page.edit');
    Route::put('landing-page', [\App\Http\Controllers\WO\LandingPageController::class, 'update'])->name('landing_page.update');

    // Subscription & Billing
    Route::get('subscription', [\App\Http\Controllers\WO\SubscriptionController::class, 'index'])->name('subscription.index');
    Route::get('subscription/checkout/{plan}', [\App\Http\Controllers\WO\SubscriptionController::class, 'checkout'])->name('subscription.checkout');
    Route::post('subscription/checkout/{plan}', [\App\Http\Controllers\WO\SubscriptionController::class, 'store'])->name('subscription.store');
});

// Client Panel Routes
Route::middleware(['auth', 'role:client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Client\ClientController::class, 'dashboard'])->name('dashboard');
    Route::get('/schedule', [\App\Http\Controllers\Client\ClientController::class, 'schedule'])->name('schedule');
    Route::get('/budget', [\App\Http\Controllers\Client\ClientController::class, 'budget'])->name('budget');
    Route::get('/vendors', [\App\Http\Controllers\Client\ClientController::class, 'vendors'])->name('vendors');
    Route::get('/guests', [\App\Http\Controllers\Client\ClientController::class, 'guests'])->name('guests');
    Route::get('/rundown', [\App\Http\Controllers\Client\ClientController::class, 'rundown'])->name('rundown');
    Route::get('/notes', [\App\Http\Controllers\Client\ClientController::class, 'notes'])->name('notes');
    Route::post('/notes', [\App\Http\Controllers\Client\ClientController::class, 'storeNote'])->name('notes.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public Wedding Organizer Profile Landing Page
Route::get('/wo/{slug}', [\App\Http\Controllers\PublicWoController::class, 'show'])->name('public.wo.show');
Route::post('/wo/{wo}/inquiry', [\App\Http\Controllers\PublicWoController::class, 'storeInquiry'])->name('public.wo.inquiry');

require __DIR__.'/auth.php';
