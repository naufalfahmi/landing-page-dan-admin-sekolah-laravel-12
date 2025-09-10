<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Announcement;
use App\Models\AnnouncementAttachment;
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

        // Get documents from announcement_attachments (published announcements)
        $documents = AnnouncementAttachment::with(['announcement.category'])
            ->whereHas('announcement', function($q) { $q->published(); })
            ->latest('id')
            ->take(4)
            ->get()
            ->map(function ($att) {
                $path = parse_url($att->file_url, PHP_URL_PATH) ?? '';
                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                $fileSize = $att->file_size ? $this->formatBytes($att->file_size) : $this->getFileSize($att->file_url);
                return (object) [
                    'id' => $att->id,
                    'title' => $att->announcement->title,
                    'description' => $att->announcement->summary,
                    'file_url' => $att->file_url,
                    'file_type' => $ext ?: ($att->file_type ?: ''),
                    'file_size' => $fileSize,
                    'category_label' => $att->announcement->category_label,
                    'announcement_slug' => $att->announcement->slug,
                    'published_at' => $att->announcement->published_at,
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
    private function getFileSize($fileUrl)
    {
        $pathPart = parse_url($fileUrl, PHP_URL_PATH) ?: '';
        $fullPath = public_path(ltrim($pathPart, '/'));
        if (is_string($fullPath) && file_exists($fullPath)) {
            return $this->formatBytes(filesize($fullPath));
        }
        return '-';
    }

    private function formatBytes($bytes)
    {
        if (!$bytes || $bytes <= 0) return '-';
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0; $size = (float) $bytes;
        while ($size > 1024 && $i < count($units) - 1) { $size /= 1024; $i++; }
        return round($size, 1) . ' ' . $units[$i];
    }
}
