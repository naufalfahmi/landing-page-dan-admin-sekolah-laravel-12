<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'author_id',
        'status',
        'views',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
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
     * Scope for published articles
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Get the author that owns the article.
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Get the categories for the article.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'article_category');
    }

    /**
     * Scope for articles by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->whereHas('categories', function($q) use ($category) {
            $q->where('slug', $category);
        });
    }
}
