<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(
            [
                'id' => 1,
                'name' => 'Pengumuman',
                'slug' => 'pengumuman',
                'active' => 1
            ],
        );
    }
}
