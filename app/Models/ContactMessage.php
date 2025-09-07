<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'read_at'
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    /**
     * Scope untuk pesan yang belum dibaca
     */
    public function scopeUnread($query)
    {
        return $query->where('status', 'unread');
    }

    /**
     * Scope untuk pesan yang sudah dibaca
     */
    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    /**
     * Scope untuk pesan yang sudah dibalas
     */
    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    /**
     * Mark pesan sebagai sudah dibaca
     */
    public function markAsRead()
    {
        $this->update([
            'status' => 'read',
            'read_at' => now()
        ]);
    }

    /**
     * Mark pesan sebagai sudah dibalas
     */
    public function markAsReplied()
    {
        $this->update([
            'status' => 'replied'
        ]);
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'unread' => 'badge-danger',
            'read' => 'badge-warning',
            'replied' => 'badge-success',
            default => 'badge-secondary'
        };
    }

    /**
     * Get status text in Indonesian
     */
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'unread' => 'Belum Dibaca',
            'read' => 'Sudah Dibaca',
            'replied' => 'Sudah Dibalas',
            default => 'Tidak Diketahui'
        };
    }
}
