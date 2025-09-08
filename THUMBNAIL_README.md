# 🖼️ Thumbnail Maker

Koleksi script untuk membuat thumbnail dari gambar dengan berbagai ukuran dan format.

## 📁 File yang Tersedia

1. **`thumbnail-maker.sh`** - Script Bash (menggunakan ImageMagick/sips)
2. **`thumbnail-maker.cjs`** - Script Node.js (basic version)
3. **`thumbnail-maker-sharp.cjs`** - Script Node.js dengan Sharp (advanced)
4. **`thumbnail-maker.py`** - Script Python (basic version)

## 🚀 Cara Menggunakan

### 1. Script Bash (Recommended untuk macOS)

```bash
# Buat thumbnail dari satu file
./thumbnail-maker.sh image.jpg

# Buat thumbnail dengan ukuran custom
./thumbnail-maker.sh image.jpg thumb.jpg 200 200

# Buat thumbnail untuk semua gambar di folder
./thumbnail-maker.sh ./images --folder 150

# Buat multiple sizes
./thumbnail-maker.sh image.jpg --multi 150 300 600
```

**Install ImageMagick (opsional):**
```bash
brew install imagemagick
```

### 2. Script Node.js dengan Sharp (Advanced)

```bash
# Install sharp terlebih dahulu
npm install sharp

# Buat thumbnail dari satu file
node thumbnail-maker-sharp.cjs image.jpg

# Buat thumbnail dengan ukuran dan quality custom
node thumbnail-maker-sharp.cjs image.jpg thumb.jpg 200 200 90

# Buat thumbnail untuk semua gambar di folder
node thumbnail-maker-sharp.cjs --folder ./images 150 80

# Buat multiple sizes
node thumbnail-maker-sharp.cjs --multi image.jpg 150 300 600
```

### 3. Script Python

```bash
# Buat thumbnail dari satu file
python3 thumbnail-maker.py image.jpg

# Buat thumbnail dengan ukuran custom
python3 thumbnail-maker.py image.jpg -o thumb.jpg -w 200 -h 200

# Buat thumbnail untuk semua gambar di folder
python3 thumbnail-maker.py ./images --folder -w 150

# Buat multiple sizes
python3 thumbnail-maker.py image.jpg --multi 150 300 600
```

### 4. Script Node.js Basic

```bash
# Buat thumbnail dari satu file
node thumbnail-maker.cjs image.jpg

# Buat thumbnail untuk semua gambar di folder
node thumbnail-maker.cjs --folder ./images 150
```

## 📋 Fitur

### ✅ Yang Sudah Tersedia
- ✅ Membuat thumbnail dari file tunggal
- ✅ Batch processing untuk folder
- ✅ Multiple sizes sekaligus
- ✅ Support berbagai format gambar (JPG, PNG, GIF, BMP, WebP)
- ✅ Auto-create folder thumbnails
- ✅ Error handling
- ✅ Progress indicator

### 🔧 Tools yang Digunakan
- **ImageMagick** (convert) - Professional image processing
- **sips** - macOS built-in image tool
- **Sharp** - Node.js image processing library
- **PIL/Pillow** - Python image library

## 📊 Perbandingan Script

| Script | Kecepatan | Kualitas | Dependencies | Platform |
|--------|-----------|----------|--------------|----------|
| Bash + ImageMagick | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | ImageMagick | Cross-platform |
| Bash + sips | ⭐⭐⭐⭐ | ⭐⭐⭐⭐ | None (macOS) | macOS only |
| Node.js + Sharp | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | Sharp | Cross-platform |
| Python | ⭐⭐⭐ | ⭐⭐⭐ | PIL/Pillow | Cross-platform |

## 🎯 Contoh Penggunaan

### Membuat Thumbnail untuk Website
```bash
# Buat thumbnail 150x150 untuk gallery
./thumbnail-maker.sh ./gallery --folder 150

# Hasil: ./gallery/thumbnails/image1_thumb.jpg
```

### Membuat Multiple Sizes untuk Responsive
```bash
# Buat 3 ukuran berbeda
./thumbnail-maker.sh hero-image.jpg --multi 150 300 600

# Hasil: 
# hero-image_150x150.jpg
# hero-image_300x300.jpg  
# hero-image_600x600.jpg
```

### Batch Processing untuk Upload
```bash
# Process semua gambar di folder upload
node thumbnail-maker-sharp.js --folder ./uploads 200 85
```

## 🔧 Troubleshooting

### ImageMagick tidak tersedia
```bash
# Install ImageMagick
brew install imagemagick

# Atau gunakan sips (macOS built-in)
./thumbnail-maker.sh image.jpg
```

### Sharp tidak terinstall
```bash
# Install sharp
npm install sharp

# Atau gunakan script basic
node thumbnail-maker.js image.jpg
```

### Permission denied
```bash
# Berikan permission execute
chmod +x thumbnail-maker.sh
```

## 📝 Tips

1. **Untuk kualitas terbaik**: Gunakan ImageMagick atau Sharp
2. **Untuk kecepatan**: Gunakan Sharp (Node.js)
3. **Untuk kemudahan**: Gunakan script Bash dengan sips (macOS)
4. **Untuk batch processing**: Gunakan `--folder` option
5. **Untuk responsive images**: Gunakan `--multi` option

## 🎨 Customization

Anda bisa memodifikasi script sesuai kebutuhan:
- Ubah default size di script
- Tambahkan format gambar lain
- Modifikasi quality settings
- Tambahkan watermark atau efek lain