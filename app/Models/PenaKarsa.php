<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class PenaKarsa extends Model
{
    use HasFactory;

    protected $table = 'pena_karsa';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'author_name',
        'author_type',
        'author_class',
        'author_position',
        'type',
        'status',
        'views',
        'is_featured',
        'tags',
        'published_at'
    ];

    protected $casts = [
        'tags' => 'array',
        'is_featured' => 'boolean',
        'views' => 'integer',
        'published_at' => 'datetime'
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
     * Scope for published articles
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope for featured articles
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for articles by author type
     */
    public function scopeByAuthorType($query, $type)
    {
        return $query->where('author_type', $type);
    }

    /**
     * Scope for articles by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get the author display name with additional info
     */
    public function getAuthorDisplayAttribute()
    {
        $display = $this->author_name;
        
        if ($this->author_type === 'student' && $this->author_class) {
            $display .= ' (Kelas ' . $this->author_class . ')';
        } elseif ($this->author_type === 'teacher' && $this->author_position) {
            $display .= ' (' . $this->author_position . ')';
        }
        
        return $display;
    }

    /**
     * Get the article type in Indonesian
     */
    public function getTypeDisplayAttribute()
    {
        $types = [
            'article' => 'Artikel',
            'opinion' => 'Opini',
            'essay' => 'Esai',
            'motivation' => 'Motivasi',
            'creative' => 'Kreatif'
        ];

        return $types[$this->type] ?? 'Artikel';
    }

    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Get tags as comma-separated string
     */
    public function getTagsAsString()
    {
        if (!$this->tags) {
            return '';
        }

        if (is_array($this->tags)) {
            // Handle corrupted data - try to reconstruct the original array
            $allTags = [];
            foreach ($this->tags as $tag) {
                if (is_string($tag)) {
                    // Clean up the string and try to extract individual tags
                    $cleanTag = trim($tag, '[]"');
                    if (strpos($cleanTag, ',') !== false) {
                        // Split by comma and clean each part
                        $parts = explode(',', $cleanTag);
                        foreach ($parts as $part) {
                            $cleanPart = trim($part, ' "');
                            if (!empty($cleanPart)) {
                                $allTags[] = $cleanPart;
                            }
                        }
                    } else {
                        $cleanPart = trim($cleanTag, ' "');
                        if (!empty($cleanPart)) {
                            $allTags[] = $cleanPart;
                        }
                    }
                } else {
                    $allTags[] = $tag;
                }
            }
            
            // Remove duplicates and return as comma-separated string
            $uniqueTags = array_unique($allTags);
            return implode(', ', $uniqueTags);
        }

        return $this->tags;
    }

    /**
     * Get tags as clean array for display
     */
    public function getCleanTags()
    {
        if (!$this->tags) {
            return [];
        }

        if (is_array($this->tags)) {
            // Handle corrupted data - try to reconstruct the original array
            $allTags = [];
            foreach ($this->tags as $tag) {
                if (is_string($tag)) {
                    // Clean up the string and try to extract individual tags
                    $cleanTag = trim($tag, '[]"');
                    if (strpos($cleanTag, ',') !== false) {
                        // Split by comma and clean each part
                        $parts = explode(',', $cleanTag);
                        foreach ($parts as $part) {
                            $cleanPart = trim($part, ' "');
                            if (!empty($cleanPart)) {
                                $allTags[] = $cleanPart;
                            }
                        }
                    } else {
                        $cleanPart = trim($cleanTag, ' "');
                        if (!empty($cleanPart)) {
                            $allTags[] = $cleanPart;
                        }
                    }
                } else {
                    $allTags[] = $tag;
                }
            }
            
            // Remove duplicates and return as clean array
            return array_values(array_unique($allTags));
        }

        return [];
    }
}
