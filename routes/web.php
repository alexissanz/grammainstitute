<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmailTestController;
use App\Http\Controllers\Admin\LanguagesController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// Language switch
Route::get('/lang/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

// Public site
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/courses', [PublicController::class, 'courses'])->name('courses');
Route::get('/methodology', [PublicController::class, 'methodology'])->name('methodology');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::get('/privacy', [PublicController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PublicController::class, 'terms'])->name('terms');

// Dashboard (auth)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::get('/email-test', [EmailTestController::class, 'index'])->name('email-test.index');
    Route::post('/email-test', [EmailTestController::class, 'send'])->name('email-test.send');

    Route::get('/languages', [LanguagesController::class, 'index'])->name('languages.index');
});

// Profile (auth)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
