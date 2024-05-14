<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category_post()
    {
        return $this->belongsToMany(Category::class, 'category_post')->withTimestamps();
    }

    public function status()
    {
        $text = '';
        switch ($this->status) {
            case 'publish':
                $text = '<span class="badge badge-success">Publish</span>';
                break;

            default:
                $text = '<span class="badge badge-warning">Draft</span>';
                break;
        }

        return $text;
    }
}
