<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PageView;
use Illuminate\Support\Facades\Log;

class TrackPageViews
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track GET requests and exclude admin routes
        if ($request->isMethod('GET') && !$request->is('admin/*') && !$request->is('api/*')) {
            try {
                $this->trackPageView($request);
            } catch (\Exception $e) {
                // Log error but don't break the request
                Log::error('Page view tracking error: ' . $e->getMessage());
            }
        }

        return $response;
    }

    /**
     * Track page view
     */
    private function trackPageView(Request $request)
    {
        $url = $request->fullUrl();
        $pageTitle = $this->getPageTitle($request);
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        $referer = $request->header('referer');
        $sessionId = $request->session()->getId();

        // Skip tracking for certain conditions
        if ($this->shouldSkipTracking($request, $ipAddress)) {
            Log::info('Page view tracking skipped', [
                'url' => $url,
                'ip' => $ipAddress,
                'user_agent' => $userAgent,
                'reason' => 'Skip conditions met'
            ]);
            return;
        }

        try {
            PageView::create([
                'url' => $url,
                'page_title' => $pageTitle,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'referer' => $referer,
                'session_id' => $sessionId,
                'viewed_at' => now()
            ]);

            Log::info('Page view tracked successfully', [
                'url' => $url,
                'page_title' => $pageTitle,
                'ip' => $ipAddress
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to track page view', [
                'url' => $url,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get page title from request
     */
    private function getPageTitle(Request $request)
    {
        // Try to get title from route name or URL
        $routeName = $request->route()?->getName();
        
        if ($routeName) {
            return match($routeName) {
                'home' => 'Beranda',
                'contact' => 'Hubungi Kami',
                'articles.index' => 'Artikel',
                'galleries.index' => 'Galeri',
                'announcements.index' => 'Pengumuman',
                'documents' => 'Dokumen',
                default => ucfirst(str_replace('.', ' ', $routeName))
            };
        }

        // Fallback to URL path
        $path = $request->path();
        if ($path === '/') {
            return 'Beranda';
        }

        return ucfirst(str_replace(['/', '-'], [' ', ' '], $path));
    }

    /**
     * Check if should skip tracking
     */
    private function shouldSkipTracking(Request $request, string $ipAddress): bool
    {
        // Skip for localhost/development only in production
        if (app()->environment('production') && in_array($ipAddress, ['127.0.0.1', '::1', 'localhost'])) {
            return true;
        }

        // Skip for bot user agents
        $userAgent = $request->userAgent();
        if ($userAgent && $this->isBot($userAgent)) {
            return true;
        }

        // Skip for certain file types
        $path = $request->path();
        if (preg_match('/\.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$/', $path)) {
            return true;
        }

        return false;
    }

    /**
     * Check if user agent is a bot
     */
    private function isBot(string $userAgent): bool
    {
        $bots = [
            'googlebot', 'bingbot', 'slurp', 'duckduckbot', 'baiduspider',
            'yandexbot', 'facebookexternalhit', 'twitterbot', 'rogerbot',
            'linkedinbot', 'embedly', 'quora link preview', 'showyoubot',
            'outbrain', 'pinterest', 'developers.google.com/+/web/snippet'
        ];

        $userAgent = strtolower($userAgent);
        
        foreach ($bots as $bot) {
            if (strpos($userAgent, $bot) !== false) {
                return true;
            }
        }

        return false;
    }
}
