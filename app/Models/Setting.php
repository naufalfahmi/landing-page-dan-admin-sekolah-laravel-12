<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    public static function getValue(string $key, $default = null)
    {
        if (!Schema::hasTable('settings')) {
            return $default;
        }
        $row = static::where('key', $key)->first();
        return $row?->value ?? $default;
    }

    public static function setValue(string $key, $value, ?string $group = null): self
    {
        return static::updateOrCreate(['key' => $key], ['value' => $value, 'group' => $group]);
    }
}


