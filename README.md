# SMPIT Al-Itqon — Laravel 12 + Bootstrap 5

Portal artikel keislaman berbasis Laravel 12 yang ringan, SEO‑aware, dan mobile‑first.

## ✨ Fitur

- **Artikel**: CRUD artikel, slug, tanggal terbit, gambar, excerpt, konten HTML.
- **Kategori**: Relasi many‑to‑many `Article ↔ Category`, halaman listing per kategori.
- **Penulis**: Model penulis dan halaman profil penulis sederhana.
- **Admin Area**: Dashboard, manajemen konten dasar (Laravel Breeze auth).
- **Shortlink**: Link pendek untuk bagikan artikel.
- **SEO**:
  - Microdata Schema.org `Article` (homepage card & halaman detail)
  - `<meta name="robots">` otomatis: homepage `index,follow`, halaman lain `noindex,follow`
  - Canonical link per halaman
  - `robots.txt` blokir `/admin/`, `/admin-access-itqon`, `/register`, `/password/`
- **UI/UX**:
  - Navbar sticky (`sticky-top`), responsif, kategori dinamis
  - Kartu artikel dengan kategori, penulis, dan tanggal
  - Pagination kustom
  - Footer sederhana: © YEAR APP_NAME
- **Settings**: Metadata situs (judul, ikon, favicon, keywords, description) via `settings` table.

## 🧱 Arsitektur & Direktori Penting

```
app/
  Http/Controllers/
    Admin/...
    ShortlinkController.php
  Models/
    Article.php, Author.php, Category.php, Setting.php, Shortlink.php
resources/views/
  layouts/
    app.blade.php         # Layout utama (+ meta robots & canonical)
    navigation.blade.php  # Navbar sticky-top
    footer.blade.php      # Footer © YEAR APP_NAME
  home.blade.php          # Listing artikel (card sebagai <article>)
  article-detail.blade.php# Detail artikel (Schema.org Article)
  category.blade.php      # Halaman kategori
routes/
  web.php, auth.php
database/
  migrations/             # Articles, Authors, Categories, Settings, pivot
  seeders/                # Contoh data artikel & kategori
public/
  robots.txt              # Disallow admin & auth
```

## 🚀 Menjalankan Proyek

1) Install dependencies
```bash
composer install
npm install
```

2) Environment
```bash
cp .env.example .env
php artisan key:generate
```

3) Database (SQLite bawaan tersedia)
```bash
php artisan migrate --seed
```

4) Asset & Server
```bash
npm run dev   # atau npm run build
php artisan serve
```

Akses `http://localhost:8000`

## 🔐 Autentikasi & Admin

- Otentikasi menggunakan Laravel Breeze.
- Admin menu muncul saat login.
- Direkomendasikan menambah middleware/guard untuk rute admin produksi.

## 🔎 SEO Checklist (sudah diterapkan)

- Homepage dapat diindeks; halaman lain noindex (meta robots dinamis).
- Schema.org `Article` di homepage dan detail.
- Canonical tag per halaman.
- `robots.txt` memblokir halaman sensitif.

Tambahan yang disarankan:
- Sitemap (`/sitemap.xml`) berisi daftar artikel published dan kategori.
- Open Graph / Twitter Card meta (title, description, image) untuk social preview.

## 🧪 Perintah Berguna

```bash
php artisan migrate:fresh --seed   # reset + seed ulang
php artisan tinker                 # eksplorasi cepat
```

## 📄 Lisensi

MIT. Silakan gunakan dan modifikasi sesuai kebutuhan.

— Dibuat dengan ❤️ menggunakan Laravel 12 & Bootstrap 5
