<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VolunteerController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/volunteers', [VolunteerController::class, 'store'])->name('volunteers.store');

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        Route::resource('zones', \App\Http\Controllers\Admin\ZoneController::class);
        Route::resource('donations', \App\Http\Controllers\Admin\DonationController::class);
        Route::resource('donation-points', \App\Http\Controllers\Admin\DonationPointController::class);
        Route::resource('volunteers', \App\Http\Controllers\Admin\VolunteerController::class)->except(['create', 'store']);
        Route::resource('coordinators', \App\Http\Controllers\Admin\CoordinatorController::class);
    });
});

require __DIR__.'/auth.php';
