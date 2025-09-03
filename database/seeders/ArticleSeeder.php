<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Article;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Authors
        $authors = [
            [
                'name' => 'Ustadz Ahmad Fauzi',
                'email' => 'ahmad.fauzi@portal-islam.com',
                'bio' => 'Ahli Fikih dan Ibadah dengan pengalaman 15 tahun dalam mengajar dan berdakwah.',
                'specialization' => 'Fikih',
                'is_active' => true,
            ],
            [
                'name' => 'Ustadzah Fatimah Azzahra',
                'email' => 'fatimah.azzahra@portal-islam.com',
                'bio' => 'Pakar Adab dan Akhlak Islam, penulis buku-buku tentang etika muslim.',
                'specialization' => 'Adab',
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Muhammad Rizki',
                'email' => 'muhammad.rizki@portal-islam.com',
                'bio' => 'Sejarawan Islam dan peneliti biografi para sahabat Nabi.',
                'specialization' => 'Riwayat',
                'is_active' => true,
            ],
            [
                'name' => 'Ustadz Abdullah Rahman',
                'email' => 'abdullah.rahman@portal-islam.com',
                'bio' => 'Pakar teknologi dan modernitas dalam perspektif Islam.',
                'specialization' => 'Opini',
                'is_active' => true,
            ],
            [
                'name' => 'Ustadz Umar Hidayat',
                'email' => 'umar.hidayat@portal-islam.com',
                'bio' => 'Ahli Tafsir Al-Quran dan kajian keislaman kontemporer.',
                'specialization' => 'Al-Quran',
                'is_active' => true,
            ],
        ];

        foreach ($authors as $authorData) {
            Author::firstOrCreate(
                ['email' => $authorData['email']],
                $authorData
            );
        }

        // Get created authors
        $ahmadFauzi = Author::where('email', 'ahmad.fauzi@portal-islam.com')->first();
        $fatimahAzzahra = Author::where('email', 'fatimah.azzahra@portal-islam.com')->first();
        $muhammadRizki = Author::where('email', 'muhammad.rizki@portal-islam.com')->first();
        $abdullahRahman = Author::where('email', 'abdullah.rahman@portal-islam.com')->first();
        $umarHidayat = Author::where('email', 'umar.hidayat@portal-islam.com')->first();

        // Create sample articles
        $articles = [
            // Al-Quran Articles
            [
                'title' => 'Keutamaan Membaca Al-Quran di Bulan Ramadhan',
                'excerpt' => 'Pelajari berbagai keutamaan dan pahala yang didapatkan ketika membaca Al-Quran di bulan suci Ramadhan.',
                'content' => '<p>Bulan Ramadhan adalah bulan yang penuh berkah dan keutamaan. Salah satu amalan yang sangat dianjurkan di bulan suci ini adalah membaca Al-Quran.</p><p>Rasulullah SAW bersabda: "Barangsiapa yang membaca satu huruf dari Al-Quran, maka baginya satu kebaikan, dan satu kebaikan akan dilipatgandakan menjadi sepuluh kebaikan."</p>',
                'author_id' => $umarHidayat->id,
                'categories' => ['Al-Quran'],
                'image' => 'https://picsum.photos/800/600?random=1',
                'status' => 'published',
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Tafsir Surat Al-Fatihah: Makna dan Keutamaannya',
                'excerpt' => 'Surat Al-Fatihah adalah surat pembuka dalam Al-Quran yang memiliki makna mendalam dan keutamaan yang besar.',
                'content' => '<p>Surat Al-Fatihah adalah surat yang paling agung dalam Al-Quran. Surat ini memiliki nama lain seperti Ummul Kitab (Induk Al-Kitab) dan As-Sab\'ul Matsani (Tujuh yang Diulang).</p><p>Surat ini wajib dibaca dalam setiap rakaat shalat, baik shalat fardhu maupun sunnah.</p>',
                'author_id' => $umarHidayat->id,
                'categories' => ['Al-Quran'],
                'image' => 'https://picsum.photos/800/600?random=6',
                'status' => 'published',
                'published_at' => now()->subDays(6),
            ],
            [
                'title' => 'Memahami Makna Ayat-Ayat Al-Quran tentang Kehidupan',
                'excerpt' => 'Al-Quran memberikan petunjuk yang jelas tentang bagaimana menjalani kehidupan yang baik dan diridhai Allah.',
                'content' => '<p>Al-Quran bukan hanya kitab suci yang dibaca, tetapi juga petunjuk hidup yang harus dipahami dan diamalkan. Setiap ayat memiliki makna yang mendalam dan relevan dengan kehidupan manusia.</p>',
                'author_id' => $umarHidayat->id,
                'categories' => ['Al-Quran'],
                'image' => 'https://picsum.photos/800/600?random=7',
                'status' => 'published',
                'published_at' => now()->subDays(7),
            ],

            // Hadis Articles
            [
                'title' => 'Kumpulan Hadis Shahih tentang Keutamaan Shalat',
                'excerpt' => 'Hadis-hadis shahih yang menjelaskan keutamaan dan pentingnya shalat dalam kehidupan seorang muslim.',
                'content' => '<p>Shalat adalah tiang agama. Barangsiapa yang mendirikan shalat, maka ia telah mendirikan agama. Dan barangsiapa yang meninggalkan shalat, maka ia telah merobohkan agama.</p>',
                'author_id' => $ahmadFauzi->id,
                'categories' => ['Hadis'],
                'image' => 'https://picsum.photos/800/600?random=8',
                'status' => 'published',
                'published_at' => now()->subDays(8),
            ],
            [
                'title' => 'Hadis Nabi tentang Pentingnya Menuntut Ilmu',
                'excerpt' => 'Rasulullah SAW sangat menganjurkan umatnya untuk menuntut ilmu dari buaian hingga liang lahat.',
                'content' => '<p>Menuntut ilmu adalah kewajiban bagi setiap muslim. Rasulullah SAW bersabda: "Menuntut ilmu adalah kewajiban bagi setiap muslim laki-laki dan perempuan."</p>',
                'author_id' => $ahmadFauzi->id,
                'categories' => ['Hadis'],
                'image' => 'https://picsum.photos/800/600?random=9',
                'status' => 'published',
                'published_at' => now()->subDays(9),
            ],

            // Riwayat Articles
            [
                'title' => 'Kisah Inspiratif Para Sahabat Nabi',
                'excerpt' => 'Para sahabat Nabi adalah teladan terbaik dalam mengamalkan ajaran Islam.',
                'content' => '<p>Para sahabat Nabi Muhammad SAW adalah generasi terbaik yang pernah ada di muka bumi ini. Mereka adalah orang-orang yang beriman, berjuang, dan berkorban untuk menegakkan agama Allah SWT.</p>',
                'author_id' => $muhammadRizki->id,
                'categories' => ['Riwayat'],
                'image' => 'https://picsum.photos/800/600?random=3',
                'status' => 'published',
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Sejarah Perkembangan Islam di Nusantara',
                'excerpt' => 'Perjalanan panjang Islam masuk dan berkembang di Indonesia hingga menjadi agama mayoritas.',
                'content' => '<p>Islam masuk ke Nusantara melalui berbagai jalur perdagangan dan dakwah. Para ulama dan pedagang muslim membawa ajaran Islam dengan cara yang damai dan toleran.</p>',
                'author_id' => $muhammadRizki->id,
                'categories' => ['Riwayat'],
                'image' => 'https://picsum.photos/800/600?random=10',
                'status' => 'published',
                'published_at' => now()->subDays(10),
            ],

            // Fikih Articles
            [
                'title' => 'Hikmah Puasa Ramadhan dalam Kehidupan Sehari-hari',
                'excerpt' => 'Puasa bukan hanya menahan lapar dan dahaga, tetapi juga melatih kesabaran dan mengendalikan hawa nafsu.',
                'content' => '<p>Puasa Ramadhan bukan hanya sekedar menahan lapar dan dahaga dari terbit fajar hingga terbenam matahari. Lebih dari itu, puasa memiliki hikmah yang sangat dalam.</p>',
                'author_id' => $ahmadFauzi->id,
                'categories' => ['Fikih'],
                'image' => 'https://picsum.photos/800/600?random=2',
                'status' => 'published',
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Panduan Lengkap Shalat Fardhu dan Sunnah',
                'excerpt' => 'Panduan praktis melaksanakan shalat fardhu dan sunnah sesuai dengan tuntunan Rasulullah SAW.',
                'content' => '<p>Shalat adalah ibadah yang paling utama setelah syahadat. Setiap muslim wajib melaksanakan shalat lima waktu dengan benar sesuai tuntunan Rasulullah SAW.</p>',
                'author_id' => $ahmadFauzi->id,
                'categories' => ['Fikih'],
                'image' => 'https://picsum.photos/800/600?random=11',
                'status' => 'published',
                'published_at' => now()->subDays(11),
            ],

            // Tokoh Articles
            [
                'title' => 'Biografi Imam Syafi\'i: Sang Mujtahid Besar',
                'excerpt' => 'Kisah hidup Imam Syafi\'i, salah satu imam mazhab yang paling berpengaruh dalam dunia Islam.',
                'content' => '<p>Imam Syafi\'i adalah salah satu dari empat imam mazhab yang paling berpengaruh dalam dunia Islam. Beliau dikenal dengan kecerdasannya yang luar biasa dan ketekunannya dalam menuntut ilmu.</p>',
                'author_id' => $muhammadRizki->id,
                'categories' => ['Tokoh'],
                'image' => 'https://picsum.photos/800/600?random=12',
                'status' => 'published',
                'published_at' => now()->subDays(12),
            ],
            [
                'title' => 'Kisah Perjuangan Siti Khadijah RA',
                'excerpt' => 'Siti Khadijah adalah istri pertama Rasulullah SAW yang memiliki peran penting dalam perjuangan dakwah Islam.',
                'content' => '<p>Siti Khadijah RA adalah wanita yang sangat mulia. Beliau adalah istri pertama Rasulullah SAW dan orang pertama yang beriman kepada kenabian beliau.</p>',
                'author_id' => $muhammadRizki->id,
                'categories' => ['Tokoh'],
                'image' => 'https://picsum.photos/800/600?random=13',
                'status' => 'published',
                'published_at' => now()->subDays(13),
            ],

            // Adab Articles
            [
                'title' => 'Adab Berinteraksi dengan Sesama Muslim',
                'excerpt' => 'Islam mengajarkan adab yang baik dalam berinteraksi dengan sesama.',
                'content' => '<p>Islam adalah agama yang sangat memperhatikan adab dalam berinteraksi dengan sesama manusia. Setiap muslim diajarkan untuk memiliki akhlak yang mulia dalam pergaulan.</p>',
                'author_id' => $fatimahAzzahra->id,
                'categories' => ['Adab'],
                'image' => 'https://picsum.photos/800/600?random=4',
                'status' => 'published',
                'published_at' => now()->subDays(4),
            ],
            [
                'title' => 'Adab Makan dan Minum dalam Islam',
                'excerpt' => 'Tata cara makan dan minum yang baik sesuai dengan ajaran Islam dan sunnah Rasulullah SAW.',
                'content' => '<p>Islam mengajarkan adab yang baik dalam segala hal, termasuk dalam makan dan minum. Rasulullah SAW memberikan contoh yang sempurna dalam hal ini.</p>',
                'author_id' => $fatimahAzzahra->id,
                'categories' => ['Adab'],
                'image' => 'https://picsum.photos/800/600?random=14',
                'status' => 'published',
                'published_at' => now()->subDays(14),
            ],

            // Opini Articles
            [
                'title' => 'Pandangan Islam tentang Teknologi Modern',
                'excerpt' => 'Teknologi berkembang pesat di era modern. Artikel ini membahas bagaimana Islam memandang teknologi.',
                'content' => '<p>Di era modern ini, teknologi berkembang dengan sangat pesat. Hampir setiap aspek kehidupan manusia telah tersentuh oleh kemajuan teknologi.</p>',
                'author_id' => $abdullahRahman->id,
                'categories' => ['Opini'],
                'image' => 'https://picsum.photos/800/600?random=5',
                'status' => 'published',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Peran Media Sosial dalam Dakwah Islam',
                'excerpt' => 'Media sosial menjadi sarana dakwah yang efektif di era digital, namun perlu digunakan dengan bijak.',
                'content' => '<p>Media sosial telah menjadi bagian tak terpisahkan dari kehidupan modern. Sebagai muslim, kita harus memanfaatkan media sosial untuk dakwah yang positif.</p>',
                'author_id' => $abdullahRahman->id,
                'categories' => ['Opini'],
                'image' => 'https://picsum.photos/800/600?random=15',
                'status' => 'published',
                'published_at' => now()->subDays(15),
            ],

            // Perempuan Articles
            [
                'title' => 'Hak dan Kewajiban Perempuan dalam Islam',
                'excerpt' => 'Islam memberikan hak dan kewajiban yang seimbang kepada perempuan sesuai dengan fitrahnya.',
                'content' => '<p>Islam adalah agama yang sangat menghormati dan memuliakan perempuan. Allah SWT memberikan hak dan kewajiban yang seimbang kepada perempuan.</p>',
                'author_id' => $fatimahAzzahra->id,
                'categories' => ['Perempuan'],
                'image' => 'https://picsum.photos/800/600?random=16',
                'status' => 'published',
                'published_at' => now()->subDays(16),
            ],
            [
                'title' => 'Peran Perempuan dalam Pendidikan Anak',
                'excerpt' => 'Perempuan memiliki peran yang sangat penting dalam pendidikan dan pengasuhan anak-anak.',
                'content' => '<p>Perempuan adalah madrasah pertama bagi anak-anaknya. Pendidikan yang baik dari seorang ibu akan membentuk karakter anak yang baik pula.</p>',
                'author_id' => $fatimahAzzahra->id,
                'categories' => ['Perempuan'],
                'image' => 'https://picsum.photos/800/600?random=17',
                'status' => 'published',
                'published_at' => now()->subDays(17),
            ],
        ];

        foreach ($articles as $articleData) {
            // Remove categories from articleData as it's now handled by pivot table
            $categories = $articleData['categories'];
            unset($articleData['categories']);
            
            $article = Article::create($articleData);
            
            // Attach categories to article
            foreach ($categories as $categoryName) {
                $category = \App\Models\Category::where('name', $categoryName)->first();
                if ($category) {
                    $article->categories()->attach($category->id);
                }
            }
        }
    }
}
