<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $categories = [
            [
                'name' => 'Al-Quran',
                'slug' => 'al-quran',
                'description' => 'Artikel tentang Al-Quran, tafsir, dan kajian Al-Quran',
                'color' => '#10B981',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Hadis',
                'slug' => 'hadis',
                'description' => 'Artikel tentang hadis Nabi dan ilmu hadis',
                'color' => '#3B82F6',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Riwayat',
                'slug' => 'riwayat',
                'description' => 'Artikel tentang sejarah Islam dan biografi tokoh',
                'color' => '#8B5CF6',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Fikih',
                'slug' => 'fikih',
                'description' => 'Artikel tentang hukum Islam dan ibadah',
                'color' => '#F59E0B',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Tokoh',
                'slug' => 'tokoh',
                'description' => 'Artikel tentang tokoh-tokoh Islam',
                'color' => '#EF4444',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Adab',
                'slug' => 'adab',
                'description' => 'Artikel tentang akhlak dan etika Islam',
                'color' => '#06B6D4',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Opini',
                'slug' => 'opini',
                'description' => 'Artikel opini dan pemikiran Islam',
                'color' => '#84CC16',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Perempuan',
                'slug' => 'perempuan',
                'description' => 'Artikel khusus tentang perempuan dalam Islam',
                'color' => '#EC4899',
                'sort_order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert(array_merge($category, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('categories')->truncate();
    }
};
