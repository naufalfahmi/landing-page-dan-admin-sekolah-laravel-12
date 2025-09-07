<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\GalleryController;
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

// Galleries routes
Route::get('/galleries', [GalleryController::class, 'index'])->name('galleries.index');
Route::get('/galleries/{gallery}', [GalleryController::class, 'show'])->name('galleries.show');

// Contact route
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Documents route
Route::get('/documents', function (Request $request) {
    $query = \App\Models\Announcement::published()
        ->whereNotNull('attachment');
    
    // Filter by category
    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }
    
    // Filter by file type
    if ($request->filled('file_type')) {
        $fileType = $request->file_type;
        if ($fileType === 'pdf') {
            $query->where('attachment', 'LIKE', '%.pdf');
        } elseif ($fileType === 'doc') {
            $query->where(function($q) {
                $q->where('attachment', 'LIKE', '%.doc')
                  ->orWhere('attachment', 'LIKE', '%.docx');
            });
        } elseif ($fileType === 'xls') {
            $query->where(function($q) {
                $q->where('attachment', 'LIKE', '%.xls')
                  ->orWhere('attachment', 'LIKE', '%.xlsx');
            });
        } elseif ($fileType === 'ppt') {
            $query->where(function($q) {
                $q->where('attachment', 'LIKE', '%.ppt')
                  ->orWhere('attachment', 'LIKE', '%.pptx');
            });
        }
    }
    
    // Search by title
    if ($request->filled('search')) {
        $query->where('title', 'LIKE', '%' . $request->search . '%');
    }
    
    $documents = $query->latest('published_at')
        ->paginate(8)
        ->withQueryString()
        ->through(function ($announcement) {
            $fileExtension = pathinfo($announcement->attachment, PATHINFO_EXTENSION);
            $fileSize = filesize(public_path($announcement->attachment)) ?? 0;
            $units = ['B', 'KB', 'MB', 'GB'];
            
            for ($i = 0; $fileSize > 1024 && $i < count($units) - 1; $i++) {
                $fileSize /= 1024;
            }
            
            return (object) [
                'id' => $announcement->id,
                'title' => $announcement->title,
                'description' => $announcement->summary,
                'file_url' => $announcement->attachment,
                'file_type' => strtolower($fileExtension),
                'file_size' => round($fileSize, 1) . ' ' . $units[$i],
                'category_label' => $announcement->category_label,
                'announcement_slug' => $announcement->slug,
                'published_at' => $announcement->published_at,
            ];
        });
    
    // Get filter options
    $categories = \App\Models\Announcement::published()
        ->whereNotNull('attachment')
        ->distinct()
        ->pluck('category')
        ->map(function($category) {
            return [
                'value' => $category,
                'label' => ucfirst($category)
            ];
        });
    
    $fileTypes = [
        ['value' => 'pdf', 'label' => 'PDF'],
        ['value' => 'doc', 'label' => 'Word (DOC/DOCX)'],
        ['value' => 'xls', 'label' => 'Excel (XLS/XLSX)'],
        ['value' => 'ppt', 'label' => 'PowerPoint (PPT/PPTX)'],
    ];
    
    return view('documents.index', compact('documents', 'categories', 'fileTypes'));
})->name('documents.index');

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
    
    // Sliders management
    Route::resource('sliders', \App\Http\Controllers\Admin\SliderController::class);
    
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
