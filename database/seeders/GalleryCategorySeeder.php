<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GalleryCategory;

class GalleryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Kegiatan Belajar',
                'description' => 'Foto-foto kegiatan pembelajaran di SMPIT Al-Itqon',
                'icon' => 'fas fa-book',
                'color' => 'primary',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Ekstrakurikuler',
                'description' => 'Foto-foto kegiatan ekstrakurikuler dan pengembangan bakat siswa',
                'icon' => 'fas fa-running',
                'color' => 'success',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Acara Sekolah',
                'description' => 'Foto-foto acara dan event yang diselenggarakan sekolah',
                'icon' => 'fas fa-calendar-alt',
                'color' => 'info',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Fasilitas',
                'description' => 'Foto-foto fasilitas dan infrastruktur sekolah',
                'icon' => 'fas fa-building',
                'color' => 'secondary',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Prestasi',
                'description' => 'Foto-foto prestasi dan pencapaian siswa',
                'icon' => 'fas fa-trophy',
                'color' => 'warning',
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            GalleryCategory::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}