<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PageView extends Model
{
    protected $fillable = [
        'url',
        'page_title',
        'ip_address',
        'user_agent',
        'referer',
        'session_id',
        'viewed_at'
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    /**
     * Scope untuk page views hari ini
     */
    public function scopeToday($query)
    {
        return $query->whereDate('viewed_at', today());
    }

    /**
     * Scope untuk page views minggu ini
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('viewed_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    /**
     * Scope untuk page views bulan ini
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('viewed_at', now()->month)
                    ->whereYear('viewed_at', now()->year);
    }

    /**
     * Scope untuk page views tahun ini
     */
    public function scopeThisYear($query)
    {
        return $query->whereYear('viewed_at', now()->year);
    }

    /**
     * Scope untuk page views berdasarkan URL
     */
    public function scopeByUrl($query, $url)
    {
        return $query->where('url', $url);
    }

    /**
     * Scope untuk page views berdasarkan IP
     */
    public function scopeByIp($query, $ip)
    {
        return $query->where('ip_address', $ip);
    }

    /**
     * Get unique visitors count
     */
    public function scopeUniqueVisitors($query)
    {
        return $query->distinct('ip_address');
    }

    /**
     * Get page views statistics
     */
    public static function getStats($period = 'today')
    {
        $query = static::query();

        switch ($period) {
            case 'today':
                $query->today();
                break;
            case 'week':
                $query->thisWeek();
                break;
            case 'month':
                $query->thisMonth();
                break;
            case 'year':
                $query->thisYear();
                break;
        }

        return [
            'total_views' => $query->count(),
            'unique_visitors' => $query->uniqueVisitors()->count(),
            'top_pages' => $query->selectRaw('url, page_title, COUNT(*) as views')
                                ->groupBy('url', 'page_title')
                                ->orderBy('views', 'desc')
                                ->limit(10)
                                ->get()
        ];
    }

    /**
     * Get daily page views for chart
     */
    public static function getDailyViews($days = 30)
    {
        // Get the earliest date from actual data
        $earliestRecord = static::orderBy('viewed_at')->first();
        if (!$earliestRecord) {
            // If no data, return empty collection
            return collect();
        }
        
        $earliestDate = $earliestRecord->viewed_at;
        
        // Start from the earliest date or 30 days ago, whichever is more recent
        $startDate = $earliestDate->isAfter(now()->subDays($days)) 
            ? $earliestDate->startOfDay() 
            : now()->subDays($days)->startOfDay();
        
        // Get actual data
        $data = static::selectRaw('DATE(viewed_at) as date, COUNT(*) as views')
                    ->where('viewed_at', '>=', $startDate)
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get()
                    ->keyBy('date');
        
        // Calculate the number of days to show
        $endDate = now()->endOfDay();
        $totalDays = $startDate->diffInDays($endDate) + 1;
        
        // Fill missing dates with 0 views
        $result = collect();
        for ($i = 0; $i < $totalDays; $i++) {
            $date = $startDate->copy()->addDays($i)->format('Y-m-d');
            $result->push([
                'date' => $date,
                'views' => $data->get($date)->views ?? 0
            ]);
        }
        
        return $result;
    }
}
