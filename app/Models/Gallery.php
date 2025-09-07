<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'thumbnail',
        'category',
        'is_featured',
        'is_published',
        'sort_order',
        'views'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'sort_order' => 'integer',
        'views' => 'integer'
    ];

    /**
     * Generate slug from title
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Scope for published galleries
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope for featured galleries
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for galleries by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope for ordered galleries
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Get category label
     */
    public function getCategoryLabelAttribute()
    {
        $labels = [
            'kegiatan-belajar' => 'Kegiatan Belajar',
            'ekstrakurikuler' => 'Ekstrakurikuler',
            'acara-sekolah' => 'Acara Sekolah',
            'fasilitas' => 'Fasilitas'
        ];

        return $labels[$this->category] ?? 'Kegiatan Belajar';
    }

    /**
     * Get category icon
     */
    public function getCategoryIconAttribute()
    {
        $icons = [
            'kegiatan-belajar' => 'fas fa-book',
            'ekstrakurikuler' => 'fas fa-futbol',
            'acara-sekolah' => 'fas fa-calendar-check',
            'fasilitas' => 'fas fa-building'
        ];

        return $icons[$this->category] ?? 'fas fa-book';
    }

    /**
     * Get category color
     */
    public function getCategoryColorAttribute()
    {
        $colors = [
            'kegiatan-belajar' => 'primary',
            'ekstrakurikuler' => 'success',
            'acara-sekolah' => 'warning',
            'fasilitas' => 'info'
        ];

        return $colors[$this->category] ?? 'primary';
    }
}
