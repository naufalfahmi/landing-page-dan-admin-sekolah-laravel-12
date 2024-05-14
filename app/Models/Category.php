<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    public function status()
    {
        $icon = '';

        switch ($this->active) {
            case '1':
                $icon = '<i class="fas fa-check text-success"></i>';
                break;

            default:
                $icon = '<i class="fas fa-times text-danger"></i>';
                break;
        }

        return $icon;
    }
}
