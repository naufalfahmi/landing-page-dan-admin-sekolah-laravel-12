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
        'category_id',
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
        if (is_numeric($category)) {
            return $query->where('category_id', $category);
        }
        return $query->whereHas('category', function($q) use ($category) {
            $q->where('slug', $category);
        });
    }

    /**
     * Scope for ordered galleries
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    /**
     * Get the category that owns the gallery.
     */
    public function category()
    {
        return $this->belongsTo(GalleryCategory::class);
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
        return $this->category ? $this->category->name : 'Tidak Berkategori';
    }

    /**
     * Get category icon
     */
    public function getCategoryIconAttribute()
    {
        return $this->category ? $this->category->icon : 'fas fa-image';
    }

    /**
     * Get category color
     */
    public function getCategoryColorAttribute()
    {
        return $this->category ? $this->category->color : 'primary';
    }
}
