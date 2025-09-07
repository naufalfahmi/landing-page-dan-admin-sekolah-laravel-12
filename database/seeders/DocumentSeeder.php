<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documents = [
            [
                'title' => 'Surat Edaran Jadwal Ujian Semester Genap 2024',
                'summary' => 'Informasi lengkap mengenai jadwal ujian semester genap tahun ajaran 2023/2024 untuk semua tingkat kelas.',
                'content' => 'Dengan hormat, kami sampaikan jadwal ujian semester genap tahun ajaran 2023/2024. Ujian akan dilaksanakan mulai tanggal 15 Mei 2024 hingga 25 Mei 2024. Silakan download file terlampir untuk melihat jadwal lengkap.',
                'category' => 'akademik',
                'attachment' => '/storage/documents/jadwal-ujian-semester-genap-2024.pdf',
                'published_at' => Carbon::now()->subDays(2),
            ],
            [
                'title' => 'Formulir Pendaftaran Ekstrakurikuler Tahun 2024',
                'summary' => 'Formulir pendaftaran untuk berbagai kegiatan ekstrakurikuler yang tersedia di sekolah.',
                'content' => 'Bagi siswa yang berminat mengikuti kegiatan ekstrakurikuler, silakan download dan isi formulir pendaftaran. Formulir harus dikembalikan paling lambat tanggal 20 Januari 2024.',
                'category' => 'kegiatan',
                'attachment' => '/storage/documents/formulir-ekstrakurikuler-2024.docx',
                'published_at' => Carbon::now()->subDays(5),
            ],
            [
                'title' => 'Panduan Penggunaan Aplikasi E-Learning Sekolah',
                'summary' => 'Panduan lengkap penggunaan aplikasi e-learning untuk siswa dan orang tua.',
                'content' => 'Aplikasi e-learning sekolah telah diperbarui dengan fitur-fitur terbaru. Silakan download panduan penggunaan untuk memudahkan akses dan penggunaan aplikasi.',
                'category' => 'umum',
                'attachment' => '/storage/documents/panduan-elearning-2024.pdf',
                'published_at' => Carbon::now()->subDays(7),
            ],
            [
                'title' => 'Jadwal Kegiatan Bulan Januari 2024',
                'summary' => 'Jadwal lengkap kegiatan sekolah selama bulan Januari 2024.',
                'content' => 'Berikut adalah jadwal kegiatan sekolah selama bulan Januari 2024. Silakan simpan dan perhatikan tanggal-tanggal penting yang tercantum dalam jadwal.',
                'category' => 'kegiatan',
                'attachment' => '/storage/documents/jadwal-kegiatan-januari-2024.xlsx',
                'published_at' => Carbon::now()->subDays(10),
            ],
            [
                'title' => 'Surat Pemberitahuan Libur Semester Genap 2024',
                'summary' => 'Pemberitahuan resmi mengenai jadwal libur semester genap tahun ajaran 2023/2024.',
                'content' => 'Dengan ini kami sampaikan jadwal libur semester genap tahun ajaran 2023/2024. Libur akan dimulai tanggal 1 Juni 2024 dan masuk kembali tanggal 15 Juli 2024.',
                'category' => 'libur',
                'attachment' => '/storage/documents/surat-libur-semester-genap-2024.pdf',
                'published_at' => Carbon::now()->subDays(12),
            ],
            [
                'title' => 'Formulir Permohonan Beasiswa Prestasi 2024',
                'summary' => 'Formulir untuk mengajukan permohonan beasiswa prestasi bagi siswa berprestasi.',
                'content' => 'Bagi siswa yang memenuhi kriteria beasiswa prestasi, silakan download dan isi formulir permohonan. Dokumen pendukung harus dilampirkan sesuai ketentuan.',
                'category' => 'akademik',
                'attachment' => '/storage/documents/formulir-beasiswa-prestasi-2024.docx',
                'published_at' => Carbon::now()->subDays(15),
            ],
            [
                'title' => 'Laporan Keuangan Sekolah Triwulan IV 2023',
                'summary' => 'Laporan keuangan sekolah untuk triwulan keempat tahun 2023.',
                'content' => 'Laporan keuangan sekolah triwulan IV tahun 2023 telah selesai disusun. Laporan ini dapat diakses oleh komite sekolah dan orang tua siswa.',
                'category' => 'umum',
                'attachment' => '/storage/documents/laporan-keuangan-triwulan-iv-2023.pdf',
                'published_at' => Carbon::now()->subDays(18),
            ],
            [
                'title' => 'Jadwal Ujian Nasional 2024',
                'summary' => 'Jadwal resmi pelaksanaan ujian nasional tahun 2024 untuk tingkat SMP.',
                'content' => 'Jadwal ujian nasional tahun 2024 telah ditetapkan oleh Kementerian Pendidikan. Silakan download untuk melihat jadwal lengkap dan persiapan yang diperlukan.',
                'category' => 'ujian',
                'attachment' => '/storage/documents/jadwal-ujian-nasional-2024.pdf',
                'published_at' => Carbon::now()->subDays(20),
            ],
            [
                'title' => 'Formulir Pendaftaran Peserta Didik Baru 2024/2025',
                'summary' => 'Formulir pendaftaran untuk calon peserta didik baru tahun ajaran 2024/2025.',
                'content' => 'Pendaftaran peserta didik baru tahun ajaran 2024/2025 akan dibuka mulai tanggal 1 Februari 2024. Silakan download formulir dan persiapkan dokumen yang diperlukan.',
                'category' => 'umum',
                'attachment' => '/storage/documents/formulir-ppdb-2024-2025.docx',
                'published_at' => Carbon::now()->subDays(22),
            ],
            [
                'title' => 'Panduan Protokol Kesehatan di Sekolah',
                'summary' => 'Panduan protokol kesehatan yang harus diikuti oleh seluruh warga sekolah.',
                'content' => 'Protokol kesehatan di sekolah telah diperbarui sesuai dengan panduan terbaru. Silakan download dan ikuti panduan yang telah ditetapkan.',
                'category' => 'umum',
                'attachment' => '/storage/documents/panduan-protokol-kesehatan-2024.pdf',
                'published_at' => Carbon::now()->subDays(25),
            ],
        ];

        foreach ($documents as $document) {
            Announcement::create([
                'title' => $document['title'],
                'slug' => Str::slug($document['title']),
                'summary' => $document['summary'],
                'content' => $document['content'],
                'category' => $document['category'],
                'attachment' => $document['attachment'],
                'published_at' => $document['published_at'],
                'created_at' => $document['published_at'],
                'updated_at' => $document['published_at'],
            ]);
        }
    }
}
