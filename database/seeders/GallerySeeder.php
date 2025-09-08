<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;
use App\Models\GalleryCategory;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data foto terbaik per kategori
        $bestPhotos = [
            [
                'category_name' => 'Upacara Hardiknas',
                'title' => 'Upacara Hardiknas 2025 - Momen Terbaik',
                'description' => 'Foto terbaik dari upacara peringatan Hari Pendidikan Nasional 2025 yang diikuti seluruh siswa dan guru SMPIT Al-Itqon.',
                'filename' => 'UPACARA_HARDIKNAS_P2030706.JPG',
                'is_featured' => true,
                'sort_order' => 1
            ],
            [
                'category_name' => 'Upacara Hardiknas',
                'title' => 'Upacara Hardiknas 2025 - Detik-detik Pengibaran Bendera',
                'description' => 'Momen sakral pengibaran bendera merah putih dalam upacara Hardiknas yang penuh khidmat.',
                'filename' => 'UPACARA_HARDIKNAS_P2030705.JPG',
                'is_featured' => true,
                'sort_order' => 2
            ],
            [
                'category_name' => 'Aurelion Gen - Pelepasan',
                'title' => 'Pelepasan Angkatan Aurelion - Momen Haru',
                'description' => 'Detik-detik pelepasan siswa kelas 9 angkatan Aurelion yang penuh dengan kebanggaan dan haru.',
                'filename' => 'AURELION_GEN___PELEPASAN_P2120127.JPG',
                'is_featured' => true,
                'sort_order' => 3
            ],
            [
                'category_name' => 'Hari Anak Nasional',
                'title' => 'Hari Anak Nasional - Keceriaan Siswa',
                'description' => 'Momen ceria siswa SMPIT Al-Itqon dalam perayaan Hari Anak Nasional yang penuh kegembiraan.',
                'filename' => 'HARI_ANAK_NASIONAL_P2140630.JPG',
                'is_featured' => true,
                'sort_order' => 4
            ],
            [
                'category_name' => 'Hari Anak Nasional',
                'title' => 'Hari Anak Nasional - Aktivitas Seru',
                'description' => 'Siswa-siswi terlibat dalam berbagai aktivitas seru dan mendidik di Hari Anak Nasional.',
                'filename' => 'HARI_ANAK_NASIONAL_P2140618.JPG',
                'is_featured' => false,
                'sort_order' => 5
            ],
            [
                'category_name' => 'OSIS',
                'title' => 'Kegiatan OSIS - Semangat Kepemimpinan',
                'description' => 'Anggota OSIS SMPIT Al-Itqon menunjukkan semangat kepemimpinan dalam berbagai kegiatan sekolah.',
                'filename' => 'OSIS_P1990440.JPG',
                'is_featured' => false,
                'sort_order' => 6
            ],
            [
                'category_name' => 'OSIS Bagi Takjil',
                'title' => 'OSIS Bagi Takjil - Berbagi di Bulan Ramadan',
                'description' => 'Kegiatan mulia OSIS membagikan takjil kepada masyarakat sekitar sekolah di bulan Ramadan.',
                'filename' => 'OSIS_BAGI_TAKJIL_P1990615.JPG',
                'is_featured' => false,
                'sort_order' => 7
            ],
            [
                'category_name' => 'OSIS Pelantikan',
                'title' => 'Pelantikan OSIS - Komitmen Baru',
                'description' => 'Momen pelantikan pengurus OSIS baru dengan komitmen untuk memajukan sekolah.',
                'filename' => 'OSIS_PELANTIKAN_P1970846.JPG',
                'is_featured' => false,
                'sort_order' => 8
            ],
            [
                'category_name' => 'Quran Camp',
                'title' => 'Quran Camp - Mendalami Al-Quran',
                'description' => 'Siswa-siswi mendalami Al-Quran dalam kegiatan Quran Camp yang penuh berkah.',
                'filename' => 'QURAN_CAMP_P1990727.JPG',
                'is_featured' => false,
                'sort_order' => 9
            ],
            [
                'category_name' => 'SAT',
                'title' => 'Sekolah Alam Terpadu - Belajar dari Alam',
                'description' => 'Kegiatan SAT (Sekolah Alam Terpadu) yang mengajarkan siswa untuk belajar langsung dari alam.',
                'filename' => 'SAT_P2050344.JPG',
                'is_featured' => false,
                'sort_order' => 10
            ],
            [
                'category_name' => 'Screening PPDB',
                'title' => 'Screening PPDB - Seleksi Siswa Baru',
                'description' => 'Proses screening Penerimaan Peserta Didik Baru untuk memilih calon siswa terbaik.',
                'filename' => 'SCREENING_PPDB_P2010786.JPG',
                'is_featured' => false,
                'sort_order' => 11
            ],
            [
                'category_name' => 'Yudisium Aurelion',
                'title' => 'Yudisium Aurelion - Kelulusan Penuh Makna',
                'description' => 'Upacara yudisium angkatan Aurelion yang penuh dengan kebanggaan dan harapan masa depan.',
                'filename' => 'YUDISIUM_AURELION_P2060086.JPG',
                'is_featured' => false,
                'sort_order' => 12
            ],
            [
                'category_name' => 'MPLS 2025 - 2026',
                'title' => 'MPLS 2025-2026 - Pengenalan Lingkungan Sekolah',
                'description' => 'Masa Pengenalan Lingkungan Sekolah untuk siswa baru tahun ajaran 2025-2026.',
                'filename' => 'MPLS_2025___2026_P2140194.JPG',
                'is_featured' => false,
                'sort_order' => 13
            ],
            [
                'category_name' => 'Foto Guru - ID Card',
                'title' => 'Foto Guru - Identitas Pendidik',
                'description' => 'Foto-foto guru SMPIT Al-Itqon untuk keperluan ID card dan dokumentasi sekolah.',
                'filename' => 'FOTO_GURU___ID_CARD_P2130674.JPG',
                'is_featured' => false,
                'sort_order' => 14
            ],
            [
                'category_name' => 'Rapat Wali Murid',
                'title' => 'Rapat Wali Murid - Sinergi Pendidikan',
                'description' => 'Kegiatan rapat antara sekolah dengan wali murid untuk membahas kemajuan pendidikan siswa.',
                'filename' => 'RAPAT_WALI_MURID_P2140244.JPG',
                'is_featured' => false,
                'sort_order' => 15
            ],
            [
                'category_name' => 'Pramuka Al Itqon',
                'title' => 'Pramuka Al Itqon - Jiwa Kepanduan',
                'description' => 'Kegiatan kepramukaan yang membentuk karakter dan jiwa kepanduan siswa SMPIT Al-Itqon.',
                'filename' => 'PRAMUKA_AL_ITQON_P2150147.JPG',
                'is_featured' => false,
                'sort_order' => 16
            ],
            [
                'category_name' => '17 Agustus',
                'title' => '17 Agustus - Semangat Kemerdekaan',
                'description' => 'Perayaan Hari Kemerdekaan Republik Indonesia dengan semangat nasionalisme yang tinggi.',
                'filename' => '17_AGUSTUS_P2150808.JPG',
                'is_featured' => false,
                'sort_order' => 17
            ]
        ];

        foreach ($bestPhotos as $photoData) {
            // Cari kategori berdasarkan nama
            $category = GalleryCategory::where('name', $photoData['category_name'])->first();
            
            if ($category) {
                // Path foto di storage galleries
                $imagePath = "galleries/{$photoData['filename']}";
                $thumbnailPath = "galleries/thumbnails/{$photoData['filename']}";
                
                Gallery::updateOrCreate(
                    [
                        'slug' => \Illuminate\Support\Str::slug($photoData['title'])
                    ],
                    [
                        'title' => $photoData['title'],
                        'description' => $photoData['description'],
                        'image' => $imagePath,
                        'thumbnail' => $thumbnailPath,
                        'category_id' => $category->id,
                        'is_featured' => $photoData['is_featured'],
                        'is_published' => true,
                        'sort_order' => $photoData['sort_order'],
                        'views' => rand(10, 100) // Random views untuk simulasi
                    ]
                );
            }
        }
    }
}
