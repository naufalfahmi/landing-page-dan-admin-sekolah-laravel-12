<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'link',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope a query to only include active sliders.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order sliders by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    /**
     * Get a normalized public URL for the slider image regardless of how it's stored in DB.
     * - Accepts absolute http(s) URLs as-is
     * - Normalizes paths starting with `/storage/` or `storage/`
     * - Prepends `storage/` for relative paths (e.g., `sliders/img.jpg`)
     * - Falls back to a tiny transparent image if missing
     */
    public function getImageUrlAttribute(): string
    {
        $path = (string) ($this->image ?? '');

        if ($path === '') {
            return asset('template/images/placeholder-1200x500.png');
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        // Normalize any leading slashes
        $normalized = ltrim($path, '/');

        if (Str::startsWith($normalized, 'storage/')) {
            return asset($normalized);
        }

        return asset('storage/' . $normalized);
    }
}
