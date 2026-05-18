<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmailTestController;
use App\Http\Controllers\Admin\HeroSlidesController;
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
Route::get('/founder', [PublicController::class, 'founder'])->name('founder');
Route::get('/courses', [PublicController::class, 'courses'])->name('courses');
Route::get('/courses/{course:slug}', [PublicController::class, 'courseShow'])->name('courses.show');
Route::get('/glossary', [PublicController::class, 'glossary'])->name('glossary.index');
Route::get('/glossary/{term:slug}', [PublicController::class, 'glossaryShow'])->name('glossary.show');
Route::get('/events', [PublicController::class, 'events'])->name('events.index');
Route::get('/events/{event:slug}', [PublicController::class, 'eventShow'])->name('events.show');
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

    // Settings
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

    // Email test
    Route::get('/email-test', [EmailTestController::class, 'index'])->name('email-test.index');
    Route::post('/email-test', [EmailTestController::class, 'send'])->name('email-test.send');

    // Languages management
    Route::get('/languages', [LanguagesController::class, 'index'])->name('languages.index');
    Route::post('/languages/toggle', [LanguagesController::class, 'toggle'])->name('languages.toggle');
    Route::post('/languages/add', [LanguagesController::class, 'addLanguage'])->name('languages.add');

    // Translations editor
    Route::get('/translations/{locale}', [LanguagesController::class, 'editTranslations'])->name('translations.edit');
    Route::put('/translations/{locale}', [LanguagesController::class, 'updateTranslations'])->name('translations.update');

    // Auto-translate AJAX
    Route::post('/auto-translate', [LanguagesController::class, 'autoTranslate'])->name('auto-translate');

    // Hero slides
    Route::get('/hero-slides', [HeroSlidesController::class, 'index'])->name('hero-slides.index');
    Route::post('/hero-slides/reorder', [HeroSlidesController::class, 'reorder'])->name('hero-slides.reorder');
    Route::post('/hero-slides', [HeroSlidesController::class, 'store'])->name('hero-slides.store');
    Route::post('/hero-slides/{heroSlide}', [HeroSlidesController::class, 'update'])->name('hero-slides.update');
    Route::delete('/hero-slides/{heroSlide}', [HeroSlidesController::class, 'destroy'])->name('hero-slides.destroy');

    // Courses
    Route::get('/courses', [\App\Http\Controllers\Admin\CoursesController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [\App\Http\Controllers\Admin\CoursesController::class, 'create'])->name('courses.create');
    Route::post('/courses', [\App\Http\Controllers\Admin\CoursesController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}/edit', [\App\Http\Controllers\Admin\CoursesController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [\App\Http\Controllers\Admin\CoursesController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [\App\Http\Controllers\Admin\CoursesController::class, 'destroy'])->name('courses.destroy');

    // Glossary
    Route::get('/glossary', [\App\Http\Controllers\Admin\GlossaryController::class, 'index'])->name('glossary.index');
    Route::get('/glossary/create', [\App\Http\Controllers\Admin\GlossaryController::class, 'create'])->name('glossary.create');
    Route::post('/glossary', [\App\Http\Controllers\Admin\GlossaryController::class, 'store'])->name('glossary.store');
    Route::get('/glossary/{term}/edit', [\App\Http\Controllers\Admin\GlossaryController::class, 'edit'])->name('glossary.edit');
    Route::put('/glossary/{term}', [\App\Http\Controllers\Admin\GlossaryController::class, 'update'])->name('glossary.update');
    Route::delete('/glossary/{term}', [\App\Http\Controllers\Admin\GlossaryController::class, 'destroy'])->name('glossary.destroy');

    // Events
    Route::get('/events', [\App\Http\Controllers\Admin\EventsController::class, 'index'])->name('events.index');
    Route::get('/events/create', [\App\Http\Controllers\Admin\EventsController::class, 'create'])->name('events.create');
    Route::post('/events', [\App\Http\Controllers\Admin\EventsController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [\App\Http\Controllers\Admin\EventsController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [\App\Http\Controllers\Admin\EventsController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [\App\Http\Controllers\Admin\EventsController::class, 'destroy'])->name('events.destroy');

    // Promotions
    Route::get('/promotions', [\App\Http\Controllers\Admin\PromotionsController::class, 'index'])->name('promotions.index');
    Route::get('/promotions/create', [\App\Http\Controllers\Admin\PromotionsController::class, 'create'])->name('promotions.create');
    Route::post('/promotions', [\App\Http\Controllers\Admin\PromotionsController::class, 'store'])->name('promotions.store');
    Route::get('/promotions/{promotion}/edit', [\App\Http\Controllers\Admin\PromotionsController::class, 'edit'])->name('promotions.edit');
    Route::put('/promotions/{promotion}', [\App\Http\Controllers\Admin\PromotionsController::class, 'update'])->name('promotions.update');
    Route::delete('/promotions/{promotion}', [\App\Http\Controllers\Admin\PromotionsController::class, 'destroy'])->name('promotions.destroy');
});

// Profile (auth)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
