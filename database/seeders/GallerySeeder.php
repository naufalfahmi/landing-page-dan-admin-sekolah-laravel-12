<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gallery;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galleries = [
            // Kegiatan Belajar
            [
                'title' => 'Pembelajaran Matematika Kelas 7A',
                'description' => 'Siswa kelas 7A sedang belajar matematika dengan metode pembelajaran yang interaktif dan menyenangkan.',
                'image' => 'https://picsum.photos/800/600?random=1',
                'thumbnail' => 'https://picsum.photos/400/300?random=1',
                'category' => 'kegiatan-belajar',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Praktikum IPA di Laboratorium',
                'description' => 'Siswa melakukan praktikum IPA untuk memahami konsep sains secara langsung.',
                'image' => 'https://picsum.photos/800/600?random=2',
                'thumbnail' => 'https://picsum.photos/400/300?random=2',
                'category' => 'kegiatan-belajar',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Pembelajaran Bahasa Indonesia',
                'description' => 'Kegiatan pembelajaran bahasa Indonesia dengan diskusi kelompok yang aktif.',
                'image' => 'https://picsum.photos/800/600?random=3',
                'thumbnail' => 'https://picsum.photos/400/300?random=3',
                'category' => 'kegiatan-belajar',
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 3,
            ],

            // Ekstrakurikuler
            [
                'title' => 'Latihan Sepak Bola',
                'description' => 'Siswa berlatih sepak bola di lapangan sekolah untuk persiapan turnamen antar sekolah.',
                'image' => 'https://picsum.photos/800/600?random=4',
                'thumbnail' => 'https://picsum.photos/400/300?random=4',
                'category' => 'ekstrakurikuler',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Ekstrakurikuler Pramuka',
                'description' => 'Kegiatan pramuka untuk membentuk karakter dan kepemimpinan siswa.',
                'image' => 'https://picsum.photos/800/600?random=5',
                'thumbnail' => 'https://picsum.photos/400/300?random=5',
                'category' => 'ekstrakurikuler',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Ekstrakurikuler Seni Tari',
                'description' => 'Siswa menampilkan tarian tradisional dalam kegiatan ekstrakurikuler seni.',
                'image' => 'https://picsum.photos/800/600?random=6',
                'thumbnail' => 'https://picsum.photos/400/300?random=6',
                'category' => 'ekstrakurikuler',
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 3,
            ],

            // Acara Sekolah
            [
                'title' => 'Upacara Bendera Hari Senin',
                'description' => 'Upacara bendera rutin setiap hari Senin untuk menanamkan nilai-nilai kebangsaan.',
                'image' => 'https://picsum.photos/800/600?random=7',
                'thumbnail' => 'https://picsum.photos/400/300?random=7',
                'category' => 'acara-sekolah',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Peringatan Hari Kemerdekaan RI',
                'description' => 'Berbagai lomba dan kegiatan dalam rangka memperingati Hari Kemerdekaan Republik Indonesia.',
                'image' => 'https://picsum.photos/800/600?random=8',
                'thumbnail' => 'https://picsum.photos/400/300?random=8',
                'category' => 'acara-sekolah',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Pembagian Raport Semester',
                'description' => 'Momen pembagian raport semester kepada orang tua siswa.',
                'image' => 'https://picsum.photos/800/600?random=9',
                'thumbnail' => 'https://picsum.photos/400/300?random=9',
                'category' => 'acara-sekolah',
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 3,
            ],

            // Fasilitas
            [
                'title' => 'Laboratorium Komputer',
                'description' => 'Laboratorium komputer yang dilengkapi dengan peralatan modern untuk pembelajaran IT.',
                'image' => 'https://picsum.photos/800/600?random=10',
                'thumbnail' => 'https://picsum.photos/400/300?random=10',
                'category' => 'fasilitas',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Perpustakaan Sekolah',
                'description' => 'Perpustakaan yang nyaman dengan koleksi buku yang lengkap untuk mendukung pembelajaran.',
                'image' => 'https://picsum.photos/800/600?random=11',
                'thumbnail' => 'https://picsum.photos/400/300?random=11',
                'category' => 'fasilitas',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Lapangan Olahraga',
                'description' => 'Lapangan olahraga yang luas untuk berbagai kegiatan olahraga dan ekstrakurikuler.',
                'image' => 'https://picsum.photos/800/600?random=12',
                'thumbnail' => 'https://picsum.photos/400/300?random=12',
                'category' => 'fasilitas',
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Ruang Kelas yang Nyaman',
                'description' => 'Ruang kelas yang dilengkapi dengan fasilitas modern untuk mendukung proses pembelajaran.',
                'image' => 'https://picsum.photos/800/600?random=13',
                'thumbnail' => 'https://picsum.photos/400/300?random=13',
                'category' => 'fasilitas',
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($galleries as $gallery) {
            Gallery::create($gallery);
        }
    }
}