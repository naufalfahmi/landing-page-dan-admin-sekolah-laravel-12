<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'content',
        'category_id',
        'priority',
        'attachment',
        'attachment_name',
        'is_published',
        'is_featured',
        'published_at',
        'views'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
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
     * Scope for published announcements
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope for featured announcements
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for announcements by category
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
     * Scope for announcements by priority
     */
    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Get the category that owns the announcement.
     */
    public function category()
    {
        return $this->belongsTo(AnnouncementCategory::class, 'category_id');
    }

    /**
     * Get attachments for the announcement
     */
    public function attachments()
    {
        return $this->hasMany(AnnouncementAttachment::class)->orderBy('sort_order');
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
     * Get priority label
     */
    public function getPriorityLabelAttribute()
    {
        $labels = [
            'low' => 'Rendah',
            'normal' => 'Normal',
            'high' => 'Tinggi',
            'urgent' => 'Mendesak'
        ];

        return $labels[$this->priority] ?? 'Normal';
    }

    /**
     * Get priority color
     */
    public function getPriorityColorAttribute()
    {
        $colors = [
            'low' => 'success',
            'normal' => 'primary',
            'high' => 'warning',
            'urgent' => 'danger'
        ];

        return $colors[$this->priority] ?? 'primary';
    }
}
