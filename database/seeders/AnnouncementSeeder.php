<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Announcement;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $announcements = [
            [
                'title' => 'Jadwal Ujian Semester Ganjil Tahun Ajaran 2024/2025',
                'summary' => 'Berikut adalah jadwal lengkap ujian semester ganjil untuk semua kelas SMP. Silakan perhatikan tanggal dan waktu ujian masing-masing mata pelajaran.',
                'content' => 'Kepada seluruh siswa SMP, berikut adalah jadwal ujian semester ganjil tahun ajaran 2024/2025:

HARI PERTAMA (Senin, 9 Desember 2024)
- 07.30 - 09.30: Bahasa Indonesia
- 10.00 - 12.00: Matematika

HARI KEDUA (Selasa, 10 Desember 2024)
- 07.30 - 09.30: Bahasa Inggris
- 10.00 - 12.00: IPA

HARI KETIGA (Rabu, 11 Desember 2024)
- 07.30 - 09.30: IPS
- 10.00 - 12.00: PKN

HARI KEEMPAT (Kamis, 12 Desember 2024)
- 07.30 - 09.30: Agama
- 10.00 - 12.00: Seni Budaya

HARI KELIMA (Jumat, 13 Desember 2024)
- 07.30 - 09.30: PJOK
- 10.00 - 12.00: Prakarya

KETENTUAN:
1. Siswa hadir 15 menit sebelum ujian dimulai
2. Membawa alat tulis lengkap
3. Tidak diperkenankan membawa HP ke dalam ruang ujian
4. Menggunakan seragam sekolah lengkap

Demikian pengumuman ini disampaikan untuk diperhatikan dan dilaksanakan dengan sebaik-baiknya.',
                'category' => 'ujian',
                'priority' => 'urgent',
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Libur Semester Ganjil Tahun Ajaran 2024/2025',
                'summary' => 'Pengumuman libur semester ganjil dimulai tanggal 20 Desember 2024 dan masuk kembali tanggal 6 Januari 2025.',
                'content' => 'Kepada seluruh siswa, orang tua, dan warga sekolah,

Dengan ini kami sampaikan bahwa libur semester ganjil tahun ajaran 2024/2025 akan dimulai pada:

TANGGAL LIBUR: 20 Desember 2024
MASUK KEMBALI: 6 Januari 2025

Selama masa libur, siswa diharapkan:
1. Tetap belajar di rumah
2. Menyelesaikan tugas yang diberikan guru
3. Menjaga kesehatan dan keamanan
4. Tidak melakukan aktivitas yang merugikan diri sendiri dan orang lain

Kegiatan belajar mengajar akan dimulai kembali pada tanggal 6 Januari 2025 sesuai jadwal yang berlaku.

Demikian pengumuman ini disampaikan untuk diperhatikan.',
                'category' => 'libur',
                'priority' => 'high',
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Kegiatan Pramuka Wajib untuk Kelas 7 dan 8',
                'summary' => 'Kegiatan pramuka akan dilaksanakan setiap hari Sabtu mulai pukul 07.00 - 10.00 WIB. Kehadiran wajib untuk semua siswa kelas 7 dan 8.',
                'content' => 'Kepada seluruh siswa kelas 7 dan 8,

Kegiatan pramuka akan dilaksanakan dengan ketentuan sebagai berikut:

JADWAL KEGIATAN:
- Hari: Setiap hari Sabtu
- Waktu: 07.00 - 10.00 WIB
- Tempat: Lapangan sekolah

ATURAN KEHADIRAN:
1. Kehadiran wajib untuk semua siswa kelas 7 dan 8
2. Siswa yang tidak hadir harus memberikan surat keterangan dari orang tua
3. Seragam pramuka lengkap dengan atribut
4. Membawa buku pramuka dan alat tulis

MATERI KEGIATAN:
- Latihan baris-berbaris
- Keterampilan kepramukaan
- Permainan edukatif
- Pembentukan karakter

Demikian pengumuman ini disampaikan untuk dilaksanakan dengan sebaik-baiknya.',
                'category' => 'kegiatan',
                'priority' => 'normal',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Penerimaan Siswa Baru Tahun Ajaran 2025/2026',
                'summary' => 'Pendaftaran siswa baru untuk tahun ajaran 2025/2026 akan dibuka mulai tanggal 1 Februari 2025. Kuota terbatas, daftar segera!',
                'content' => 'Kepada masyarakat umum,

SMP membuka pendaftaran siswa baru untuk tahun ajaran 2025/2026 dengan ketentuan sebagai berikut:

JADWAL PENDAFTARAN:
- Pembukaan: 1 Februari 2025
- Penutupan: 28 Februari 2025
- Pengumuman: 15 Maret 2025

PERSYARATAN:
1. Usia minimal 12 tahun per 1 Juli 2025
2. Lulusan SD/MI atau sederajat
3. Membawa fotokopi rapor kelas 4, 5, dan 6
4. Membawa fotokopi akta kelahiran
5. Membawa fotokopi KK
6. Pas foto 3x4 sebanyak 2 lembar

KUOTA:
- Kelas 7A: 32 siswa
- Kelas 7B: 32 siswa
- Kelas 7C: 32 siswa

BIAYA PENDAFTARAN:
- Biaya pendaftaran: Rp 150.000
- Biaya daftar ulang: Rp 2.500.000

Informasi lebih lanjut dapat menghubungi panitia pendaftaran di sekolah.',
                'category' => 'akademik',
                'priority' => 'high',
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Pembagian Rapor Semester Ganjil',
                'summary' => 'Pembagian rapor semester ganjil akan dilaksanakan pada hari Sabtu, 21 Desember 2024 mulai pukul 08.00 WIB.',
                'content' => 'Kepada seluruh orang tua/wali siswa,

Pembagian rapor semester ganjil tahun ajaran 2024/2025 akan dilaksanakan dengan ketentuan sebagai berikut:

HARI/TANGGAL: Sabtu, 21 Desember 2024
WAKTU: 08.00 - 12.00 WIB
TEMPAT: Ruang kelas masing-masing

JADWAL PEMBAGIAN:
- Kelas 7: 08.00 - 09.30 WIB
- Kelas 8: 09.30 - 11.00 WIB
- Kelas 9: 11.00 - 12.00 WIB

KETENTUAN:
1. Orang tua/wali wajib hadir
2. Membawa KTP atau identitas lainnya
3. Mengambil rapor di ruang kelas anak masing-masing
4. Dapat berkonsultasi dengan wali kelas

Demikian pengumuman ini disampaikan untuk diperhatikan.',
                'category' => 'akademik',
                'priority' => 'normal',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subDays(4),
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }
    }
}