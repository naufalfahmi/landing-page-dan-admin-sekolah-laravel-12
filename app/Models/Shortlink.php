<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Shortlink extends Model
{
    use HasFactory;

    protected $fillable = [
        'short_code',
        'target_url',
        'article_id',
        'clicks',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'clicks' => 'integer'
    ];

    /**
     * Generate short code yang unik
     */
    public static function generateShortCode(): string
    {
        do {
            // Generate 8 karakter random (huruf besar + angka)
            $code = strtoupper(Str::random(8));
        } while (self::where('short_code', $code)->exists());

        return $code;
    }

    /**
     * Create atau update shortlink untuk artikel
     */
    public static function createForArticle(int $articleId, string $targetUrl): self
    {
        // Cek apakah sudah ada shortlink untuk artikel ini
        $shortlink = self::where('article_id', $articleId)->first();
        
        if ($shortlink) {
            // Update existing shortlink
            $shortlink->update([
                'target_url' => $targetUrl,
                'updated_at' => now()
            ]);
            return $shortlink;
        }

        // Create new shortlink
        return self::create([
            'short_code' => self::generateShortCode(),
            'target_url' => $targetUrl,
            'article_id' => $articleId,
            'clicks' => 0
        ]);
    }

    /**
     * Increment click count
     */
    public function incrementClicks(): void
    {
        $this->increment('clicks');
    }

    /**
     * Check if shortlink is expired
     */
    public function isExpired(): bool
    {
        if (!$this->expires_at) {
            return false;
        }
        
        return $this->expires_at->isPast();
    }

    /**
     * Get full shortlink URL
     */
    public function getFullUrlAttribute(): string
    {
        return rtrim(config('app.url'), '/') . '/s/' . $this->short_code;
    }
}
