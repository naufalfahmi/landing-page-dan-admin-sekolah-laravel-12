<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\Slider;
use App\Models\PenaKarsa;

class HomeController extends Controller
{
    /**
     * Display the home page with articles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $articles = Article::with(['author', 'categories'])
            ->published()
            ->latest('published_at')
            ->take(6)
            ->get();

        $announcements = Announcement::with('category')
            ->published()
            ->latest('published_at')
            ->take(3)
            ->get();

        $galleries = Gallery::with('category')
            ->published()
            ->ordered()
            ->take(8)
            ->get();

        // Get documents from announcements with attachments
        $documents = Announcement::with('category')
            ->published()
            ->whereNotNull('attachment')
            ->latest('published_at')
            ->take(4)
            ->get()
            ->map(function ($announcement) {
                $fileExtension = pathinfo($announcement->attachment, PATHINFO_EXTENSION);
                $fileSize = $this->getFileSize($announcement->attachment);
                
                return (object) [
                    'id' => $announcement->id,
                    'title' => $announcement->title,
                    'description' => $announcement->summary,
                    'file_url' => $announcement->attachment,
                    'file_type' => strtolower($fileExtension),
                    'file_size' => $fileSize,
                    'category_label' => $announcement->category_label,
                    'announcement_slug' => $announcement->slug,
                    'published_at' => $announcement->published_at,
                ];
            });

        // Get active sliders
        $sliders = Slider::active()->ordered()->get();

        // Get Pena Karsa articles
        $penaKarsa = PenaKarsa::published()
            ->latest('published_at')
            ->take(6)
            ->get();

        return view('home', compact('articles', 'announcements', 'galleries', 'documents', 'sliders', 'penaKarsa'));
    }

    /**
     * Get file size in human readable format
     */
    private function getFileSize($filePath)
    {
        if (file_exists(public_path($filePath))) {
            $bytes = filesize(public_path($filePath));
            $units = ['B', 'KB', 'MB', 'GB'];
            
            for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
                $bytes /= 1024;
            }
            
            return round($bytes, 1) . ' ' . $units[$i];
        }
        
        return 'Unknown';
    }
}
