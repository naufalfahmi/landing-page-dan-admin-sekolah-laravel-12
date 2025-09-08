<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Slider;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data slider dengan foto terbaik
        $sliders = [
            [
                'title' => 'Upacara Hardiknas 2025',
                'description' => 'Momen khidmat peringatan Hari Pendidikan Nasional 2025 di SMPIT Al-Itqon dengan semangat mencerdaskan kehidupan bangsa.',
                'image' => 'sliders/UPACARA_HARDIKNAS_P2030706.JPG',
                'link' => '/galleries/upacara-hardiknas-2025-momen-terbaik',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'title' => 'Pelepasan Angkatan Aurelion',
                'description' => 'Detik-detik pelepasan siswa kelas 9 angkatan Aurelion yang penuh dengan kebanggaan, haru, dan harapan masa depan.',
                'image' => 'sliders/AURELION_GEN___PELEPASAN_P2120127.JPG',
                'link' => '/galleries/pelepasan-angkatan-aurelion-momen-haru',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'title' => 'Hari Anak Nasional',
                'description' => 'Perayaan Hari Anak Nasional dengan berbagai kegiatan seru dan mendidik yang mengembangkan potensi siswa SMPIT Al-Itqon.',
                'image' => 'sliders/HARI_ANAK_NASIONAL_P2140630.JPG',
                'link' => '/galleries/hari-anak-nasional-keceriaan-siswa',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'title' => '17 Agustus - Semangat Kemerdekaan',
                'description' => 'Perayaan Hari Kemerdekaan Republik Indonesia dengan semangat nasionalisme dan cinta tanah air yang tinggi.',
                'image' => 'sliders/17_AGUSTUS_P2150808.JPG',
                'link' => '/galleries/17-agustus-semangat-kemerdekaan',
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'title' => 'MPLS 2025-2026',
                'description' => 'Masa Pengenalan Lingkungan Sekolah untuk siswa baru tahun ajaran 2025-2026 dengan semangat belajar yang tinggi.',
                'image' => 'sliders/MPLS_2025___2026_P2140194.JPG',
                'link' => '/galleries/mpls-2025-2026-pengenalan-lingkungan-sekolah',
                'is_active' => true,
                'sort_order' => 5
            ],
            [
                'title' => 'OSIS Pelantikan',
                'description' => 'Upacara pelantikan pengurus OSIS baru dengan komitmen untuk memajukan sekolah dan melayani sesama siswa.',
                'image' => 'sliders/OSIS_PELANTIKAN_P1970846.JPG',
                'link' => '/galleries/osis-pelantikan-komitmen-baru',
                'is_active' => true,
                'sort_order' => 6
            ],
            [
                'title' => 'Pramuka Al Itqon',
                'description' => 'Kegiatan kepramukaan yang membentuk karakter, jiwa kepanduan, dan semangat gotong royong siswa SMPIT Al-Itqon.',
                'image' => 'sliders/PRAMUKA_AL_ITQON_P2150147.JPG',
                'link' => '/galleries/pramuka-al-itqon-jiwa-kepanduan',
                'is_active' => true,
                'sort_order' => 7
            ],
            [
                'title' => 'Screening PPDB',
                'description' => 'Proses screening Penerimaan Peserta Didik Baru untuk memilih calon siswa terbaik yang akan bergabung dengan keluarga besar SMPIT Al-Itqon.',
                'image' => 'sliders/SCREENING_PPDB_P2010786.JPG',
                'link' => '/galleries/screening-ppdb-seleksi-siswa-baru',
                'is_active' => true,
                'sort_order' => 8
            ]
        ];

        foreach ($sliders as $sliderData) {
            Slider::updateOrCreate(
                [
                    'title' => $sliderData['title']
                ],
                $sliderData
            );
        }
    }
}
