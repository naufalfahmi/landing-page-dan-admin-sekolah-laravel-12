<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'Selamat Datang di Portal Islam',
                'description' => 'Portal resmi sekolah yang menyediakan informasi terbaru tentang kegiatan, pengumuman, dan berita sekolah.',
                'image' => 'https://picsum.photos/1200/500?random=1',
                'link' => null,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Pendidikan Berkualitas untuk Masa Depan',
                'description' => 'Kami berkomitmen memberikan pendidikan terbaik untuk membentuk generasi yang berkarakter dan berprestasi.',
                'image' => 'https://picsum.photos/1200/500?random=2',
                'link' => null,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Kegiatan Ekstrakurikuler Menarik',
                'description' => 'Bergabunglah dengan berbagai kegiatan ekstrakurikuler yang menarik dan bermanfaat untuk pengembangan diri.',
                'image' => 'https://picsum.photos/1200/500?random=3',
                'link' => null,
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }
}