<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use App\Models\Article;
use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\PenaKarsa;
use App\Models\Author;

class SitemapController extends Controller
{
    /**
     * Generate the XML sitemap.
     */
    public function index(): Response
    {
        $baseUrl = url('/');

        // Static pages
        $staticUrls = [
            [ 'loc' => route('home'), 'changefreq' => 'daily', 'priority' => '1.0' ],
            [ 'loc' => route('articles.index'), 'changefreq' => 'daily', 'priority' => '0.9' ],
            [ 'loc' => route('announcements.index'), 'changefreq' => 'hourly', 'priority' => '0.9' ],
            [ 'loc' => route('galleries.index'), 'changefreq' => 'daily', 'priority' => '0.8' ],
            [ 'loc' => route('pena-karsa.index'), 'changefreq' => 'daily', 'priority' => '0.8' ],
            [ 'loc' => route('documents.index'), 'changefreq' => 'weekly', 'priority' => '0.7' ],
            [ 'loc' => route('contact'), 'changefreq' => 'yearly', 'priority' => '0.3' ],
        ];

        // Dynamic pages
        $articles = Article::published()->latest('updated_at')->get();
        $announcements = Announcement::published()->latest('updated_at')->get();
        $galleries = Gallery::published()->latest('updated_at')->get();
        $penaKarsa = PenaKarsa::published()->latest('updated_at')->get();
        $authors = Author::active()->latest('updated_at')->get();

        // Build XML
        $xml = [];
        $xml[] = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Helper to append url nodes
        $append = function(string $loc, ?string $lastmod, string $changefreq, string $priority) use (&$xml) {
            $xml[] = '  <url>';
            $xml[] = '    <loc>' . htmlspecialchars($loc, ENT_XML1) . '</loc>';
            if ($lastmod) {
                $xml[] = '    <lastmod>' . htmlspecialchars($lastmod, ENT_XML1) . '</lastmod>';
            }
            $xml[] = '    <changefreq>' . $changefreq . '</changefreq>';
            $xml[] = '    <priority>' . $priority . '</priority>';
            $xml[] = '  </url>';
        };

        // Static
        foreach ($staticUrls as $u) {
            $append($u['loc'], null, $u['changefreq'], $u['priority']);
        }

        // Articles
        foreach ($articles as $item) {
            $append(route('article.detail', $item->slug), optional($item->updated_at ?? $item->published_at)->toAtomString(), 'weekly', '0.8');
        }

        // Announcements
        foreach ($announcements as $item) {
            $append(route('announcements.show', $item->slug), optional($item->updated_at ?? $item->published_at)->toAtomString(), 'daily', '0.8');
        }

        // Galleries
        foreach ($galleries as $item) {
            $append(route('galleries.show', $item->slug), optional($item->updated_at ?? $item->created_at)->toAtomString(), 'weekly', '0.6');
        }

        // Pena Karsa
        foreach ($penaKarsa as $item) {
            $append(route('pena-karsa.show', $item->slug), optional($item->updated_at ?? $item->published_at ?? $item->created_at)->toAtomString(), 'weekly', '0.7');
        }

        // Authors
        foreach ($authors as $author) {
            $append(route('author.show', $author->slug), optional($author->updated_at ?? $author->created_at)->toAtomString(), 'weekly', '0.5');
        }

        $xml[] = '</urlset>';

        return response(implode("\n", $xml), 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}


