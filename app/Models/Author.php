<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'email',
        'bio',
        'avatar',
        'specialization',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Set the name attribute and generate slug
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = \Str::slug($value);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the articles for the author.
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Scope for active authors
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
