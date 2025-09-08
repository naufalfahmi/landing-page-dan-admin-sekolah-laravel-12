<?php

namespace Database\Seeders;

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
                'name' => '17 Agustus',
                'description' => 'Kegiatan peringatan hari kemerdekaan Republik Indonesia',
                'icon' => 'flag',
                'color' => 'red',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Aurelion Gen - Pelepasan',
                'description' => 'Kegiatan pelepasan siswa kelas 9 angkatan Aurelion',
                'icon' => 'graduation-cap',
                'color' => 'blue',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Foto Guru - ID Card',
                'description' => 'Foto-foto guru untuk keperluan ID card',
                'icon' => 'user-tie',
                'color' => 'green',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'Hari Anak Nasional',
                'description' => 'Kegiatan peringatan hari anak nasional',
                'icon' => 'child',
                'color' => 'yellow',
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'name' => 'MPLS 2025 - 2026',
                'description' => 'Masa Pengenalan Lingkungan Sekolah tahun 2025-2026',
                'icon' => 'school',
                'color' => 'purple',
                'is_active' => true,
                'sort_order' => 5
            ],
            [
                'name' => 'OSIS',
                'description' => 'Kegiatan Organisasi Siswa Intra Sekolah',
                'icon' => 'users',
                'color' => 'indigo',
                'is_active' => true,
                'sort_order' => 6
            ],
            [
                'name' => 'OSIS Bagi Takjil',
                'description' => 'Kegiatan OSIS membagikan takjil di bulan Ramadan',
                'icon' => 'gift',
                'color' => 'orange',
                'is_active' => true,
                'sort_order' => 7
            ],
            [
                'name' => 'OSIS Pelantikan',
                'description' => 'Upacara pelantikan pengurus OSIS',
                'icon' => 'crown',
                'color' => 'gold',
                'is_active' => true,
                'sort_order' => 8
            ],
            [
                'name' => 'Pramuka Al Itqon',
                'description' => 'Kegiatan kepramukaan SMPIT Al Itqon',
                'icon' => 'campground',
                'color' => 'brown',
                'is_active' => true,
                'sort_order' => 9
            ],
            [
                'name' => 'Quran Camp',
                'description' => 'Kegiatan camp Al-Quran untuk siswa',
                'icon' => 'book-quran',
                'color' => 'teal',
                'is_active' => true,
                'sort_order' => 10
            ],
            [
                'name' => 'Rapat Wali Murid',
                'description' => 'Kegiatan rapat antara sekolah dengan wali murid',
                'icon' => 'handshake',
                'color' => 'cyan',
                'is_active' => true,
                'sort_order' => 11
            ],
            [
                'name' => 'SAT',
                'description' => 'Kegiatan SAT (Sekolah Alam Terpadu)',
                'icon' => 'tree',
                'color' => 'lime',
                'is_active' => true,
                'sort_order' => 12
            ],
            [
                'name' => 'Screening PPDB',
                'description' => 'Kegiatan screening Penerimaan Peserta Didik Baru',
                'icon' => 'clipboard-check',
                'color' => 'pink',
                'is_active' => true,
                'sort_order' => 13
            ],
            [
                'name' => 'Shalat Dhuha',
                'description' => 'Kegiatan shalat dhuha berjamaah di sekolah',
                'icon' => 'pray',
                'color' => 'amber',
                'is_active' => true,
                'sort_order' => 14
            ],
            [
                'name' => 'Upacara Hardiknas',
                'description' => 'Upacara peringatan Hari Pendidikan Nasional',
                'icon' => 'flag',
                'color' => 'emerald',
                'is_active' => true,
                'sort_order' => 15
            ],
            [
                'name' => 'Yudisium Aurelion',
                'description' => 'Upacara yudisium angkatan Aurelion',
                'icon' => 'medal',
                'color' => 'violet',
                'is_active' => true,
                'sort_order' => 16
            ]
        ];

        foreach ($categories as $category) {
            GalleryCategory::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($category['name'])],
                $category
            );
        }
    }
}
