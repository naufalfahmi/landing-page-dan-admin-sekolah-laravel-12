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

// Pena Karsa routes
Route::get('/pena-karsa', [\App\Http\Controllers\PenaKarsaController::class, 'index'])->name('pena-karsa.index');
Route::get('/pena-karsa/{slug}', [\App\Http\Controllers\PenaKarsaController::class, 'show'])->name('pena-karsa.show');

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

// Contact routes
Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])
    ->middleware('throttle:3,15') // 3 requests per 15 minutes
    ->name('contact.store');

// Documents route
Route::get('/documents', function (Request $request) {
    $query = \App\Models\Announcement::published()
        ->whereNotNull('attachment');
    
    // Filter by category
    if ($request->filled('category')) {
        $query->whereHas('category', function($q) use ($request) {
            $q->where('slug', $request->category);
        });
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

            // Resolve local filesystem path from public URL or relative path
            $attachment = $announcement->attachment;
            $pathPart = parse_url($attachment, PHP_URL_PATH) ?: $attachment;
            $filePath = public_path(ltrim($pathPart, '/'));

            $fileSize = 0;
            if (is_string($filePath) && file_exists($filePath)) {
                $fileSize = filesize($filePath) ?: 0;
            }
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
    $categories = \App\Models\AnnouncementCategory::whereHas('announcements', function($query) {
            $query->published()->whereNotNull('attachment');
        })
        ->active()
        ->ordered()
        ->get()
        ->map(function($category) {
            return [
                'value' => $category->slug,
                'label' => $category->name
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
    Route::get('/dashboard/top-pages', [AdminDashboardController::class, 'getTopPages'])->name('dashboard.top-pages');
    
    // Articles management
    Route::get('/articleCreate', [AdminArticleController::class, 'create'])->name('articles.create');
    Route::post('/articleCreate', [AdminArticleController::class, 'store'])->name('articles.store');
    Route::resource('articles', AdminArticleController::class)->except(['create', 'store']);
    
    // Authors management
    Route::get('/authorCreate', [AdminAuthorController::class, 'create'])->name('authors.create');
    Route::post('/authorCreate', [AdminAuthorController::class, 'store'])->name('authors.store');
    Route::resource('authors', AdminAuthorController::class)->except(['create', 'store']);
    
    // Categories management
    Route::get('/categoryCreate', [\App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categoryCreate', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('categories.store');
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['create', 'store']);
    
    // Sliders management
    Route::get('/sliderCreate', [\App\Http\Controllers\Admin\SliderController::class, 'create'])->name('sliders.create');
    Route::post('/sliderCreate', [\App\Http\Controllers\Admin\SliderController::class, 'store'])->name('sliders.store');
    Route::resource('sliders', \App\Http\Controllers\Admin\SliderController::class)->except(['create', 'store']);
    
    // Announcements management
    Route::get('/announcementCreate', [AdminAnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/announcementCreate', [AdminAnnouncementController::class, 'store'])->name('announcements.store');
    Route::post('/announcements/category', [AdminAnnouncementController::class, 'storeCategory'])->name('announcements.category.store');
    Route::delete('/announcements/{announcement}/attachments/{attachment}', [AdminAnnouncementController::class, 'destroyAttachment'])->name('announcements.attachments.destroy');
    // Share to WhatsApp
    Route::get('/announcements/{announcement}/share-whatsapp', [AdminAnnouncementController::class, 'shareWhatsapp'])->name('announcements.share-whatsapp');
    Route::resource('announcements', AdminAnnouncementController::class)->except(['create', 'store']);
    
    // Announcement Categories management
    Route::get('/announcementCategoryCreate', [\App\Http\Controllers\Admin\AnnouncementCategoryController::class, 'create'])->name('announcement-categories.create');
    Route::post('/announcementCategoryCreate', [\App\Http\Controllers\Admin\AnnouncementCategoryController::class, 'store'])->name('announcement-categories.store');
    Route::resource('announcement-categories', \App\Http\Controllers\Admin\AnnouncementCategoryController::class)->except(['create', 'store']);
    
    // Galleries management
    Route::get('/galleryCreate', [\App\Http\Controllers\Admin\GalleryController::class, 'create'])->name('galleries.create');
    Route::post('/galleryCreate', [\App\Http\Controllers\Admin\GalleryController::class, 'store'])->name('galleries.store');
    Route::resource('galleries', \App\Http\Controllers\Admin\GalleryController::class)->except(['create', 'store']);
    
    // Gallery Categories management
    Route::get('/galleryCategoryCreate', [\App\Http\Controllers\Admin\GalleryCategoryController::class, 'create'])->name('gallery-categories.create');
    Route::post('/galleryCategoryCreate', [\App\Http\Controllers\Admin\GalleryCategoryController::class, 'store'])->name('gallery-categories.store');
    Route::resource('gallery-categories', \App\Http\Controllers\Admin\GalleryCategoryController::class)->except(['create', 'store']);
    
    // Contact messages management
    Route::get('/contact', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contact.index');
    Route::get('/contact/{contact}', [\App\Http\Controllers\Admin\ContactController::class, 'show'])->name('contact.show');
    Route::patch('/contact/{contact}/mark-replied', [\App\Http\Controllers\Admin\ContactController::class, 'markAsReplied'])->name('contact.mark-replied');
    Route::delete('/contact/{contact}', [\App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('contact.destroy');
    
    // Pena Karsa management
    Route::get('/penaKarsaCreate', [\App\Http\Controllers\Admin\PenaKarsaController::class, 'create'])->name('pena-karsa.create');
    Route::post('/penaKarsaCreate', [\App\Http\Controllers\Admin\PenaKarsaController::class, 'store'])->name('pena-karsa.store');
    Route::resource('pena-karsa', \App\Http\Controllers\Admin\PenaKarsaController::class)->except(['create', 'store']);

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
