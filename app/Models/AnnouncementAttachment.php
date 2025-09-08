<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnnouncementAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'announcement_id',
        'file_url',
        'file_name',
        'file_type',
        'file_size',
        'sort_order',
    ];

    public function announcement()
    {
        return $this->belongsTo(Announcement::class);
    }
}
