<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ShortlinkController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\AuthorController as AdminAuthorController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Dashboard route (redirect to admin dashboard)
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Articles listing page
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

// Article detail page dengan slug
Route::get('/article/{slug}', [ArticleController::class, 'showBySlug'])->name('article.detail');

// Category page
Route::get('/category/{slug}', [ArticleController::class, 'showByCategory'])->name('category.show');

// Author page
Route::get('/author/{slug}', [ArticleController::class, 'showByAuthor'])->name('author.show');

// Announcements routes
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');

// Shortlink routes
Route::get('/s/{code}', [ShortlinkController::class, 'redirect'])->name('shortlink.redirect');

// Admin routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Articles management
    Route::resource('articles', AdminArticleController::class);
    
    // Authors management
    Route::resource('authors', AdminAuthorController::class);
    
    // Categories management
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    
    // Announcements management
    Route::resource('announcements', AdminAnnouncementController::class);
    
    // Shortlinks management
    Route::get('/shortlinks', [ShortlinkController::class, 'index'])->name('shortlinks.index');
    Route::post('/shortlinks', [ShortlinkController::class, 'store'])->name('shortlinks.store');
    Route::delete('/shortlinks/{id}', [ShortlinkController::class, 'destroy'])->name('shortlinks.destroy');

    // Settings
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'store'])->name('settings.store');
});

// Breeze authentication routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
