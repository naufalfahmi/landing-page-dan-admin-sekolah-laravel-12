<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AnnouncementCategory;

class AnnouncementCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Akademik',
                'slug' => 'akademik',
                'description' => 'Pengumuman terkait kegiatan akademik dan pembelajaran',
                'icon' => 'fas fa-graduation-cap',
                'color' => 'primary',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Kegiatan',
                'slug' => 'kegiatan',
                'description' => 'Pengumuman kegiatan sekolah dan ekstrakurikuler',
                'icon' => 'fas fa-calendar-alt',
                'color' => 'success',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Ujian',
                'slug' => 'ujian',
                'description' => 'Pengumuman terkait jadwal dan informasi ujian',
                'icon' => 'fas fa-clipboard-check',
                'color' => 'warning',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'Libur',
                'slug' => 'libur',
                'description' => 'Pengumuman hari libur dan cuti sekolah',
                'icon' => 'fas fa-calendar-times',
                'color' => 'info',
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'name' => 'Umum',
                'slug' => 'umum',
                'description' => 'Pengumuman umum dan informasi penting lainnya',
                'icon' => 'fas fa-bullhorn',
                'color' => 'secondary',
                'is_active' => true,
                'sort_order' => 5
            ]
        ];

        foreach ($categories as $category) {
            AnnouncementCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
