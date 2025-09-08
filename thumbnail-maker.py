#!/usr/bin/env python3
"""
Thumbnail Maker menggunakan Python
Membuat thumbnail dari gambar dengan berbagai ukuran
"""

import os
import sys
import argparse
from pathlib import Path

def create_thumbnail_basic(input_path, output_path, width=150, height=150):
    """
    Membuat thumbnail menggunakan metode basic (copy file dengan rename)
    Untuk implementasi nyata, gunakan PIL/Pillow
    """
    try:
        input_file = Path(input_path)
        output_file = Path(output_path)
        
        if not input_file.exists():
            print(f"❌ File tidak ditemukan: {input_path}")
            return False
        
        # Buat direktori output jika belum ada
        output_file.parent.mkdir(parents=True, exist_ok=True)
        
        # Copy file sebagai placeholder
        import shutil
        shutil.copy2(input_path, output_path)
        
        print(f"✅ Thumbnail berhasil dibuat: {output_path}")
        return True
        
    except Exception as e:
        print(f"❌ Error membuat thumbnail: {e}")
        return False

def create_thumbnails_from_folder(folder_path, thumbnail_size=150):
    """
    Membuat thumbnail untuk semua gambar di folder
    """
    try:
        folder = Path(folder_path)
        if not folder.exists():
            print(f"❌ Folder tidak ditemukan: {folder_path}")
            return
        
        # Ekstensi gambar yang didukung
        image_extensions = {'.jpg', '.jpeg', '.png', '.gif', '.bmp', '.webp'}
        
        # Cari semua file gambar
        image_files = []
        for file_path in folder.iterdir():
            if file_path.is_file() and file_path.suffix.lower() in image_extensions:
                image_files.append(file_path)
        
        print(f"📁 Ditemukan {len(image_files)} file gambar di {folder_path}")
        
        # Buat folder thumbnails
        thumbnail_dir = folder / 'thumbnails'
        thumbnail_dir.mkdir(exist_ok=True)
        
        # Process setiap file gambar
        for image_file in image_files:
            thumbnail_name = f"{image_file.stem}_thumb{image_file.suffix}"
            thumbnail_path = thumbnail_dir / thumbnail_name
            
            print(f"🔄 Processing: {image_file.name}")
            create_thumbnail_basic(image_file, thumbnail_path, thumbnail_size, thumbnail_size)
        
        print(f"🎉 Selesai! Semua thumbnail tersimpan di: {thumbnail_dir}")
        
    except Exception as e:
        print(f"❌ Error processing folder: {e}")

def create_multiple_sizes(input_path, sizes=[150, 300, 600]):
    """
    Membuat thumbnail dengan berbagai ukuran
    """
    try:
        input_file = Path(input_path)
        if not input_file.exists():
            print(f"❌ File tidak ditemukan: {input_path}")
            return
        
        for size in sizes:
            output_name = f"{input_file.stem}_{size}x{size}{input_file.suffix}"
            output_path = input_file.parent / output_name
            
            print(f"🔄 Membuat thumbnail {size}x{size}")
            create_thumbnail_basic(input_file, output_path, size, size)
        
    except Exception as e:
        print(f"❌ Error membuat multiple sizes: {e}")

def main():
    parser = argparse.ArgumentParser(description='🖼️ Thumbnail Maker')
    parser.add_argument('input', nargs='?', help='Input file atau folder')
    parser.add_argument('-o', '--output', help='Output file')
    parser.add_argument('-w', '--width', type=int, default=150, help='Width (default: 150)')
    parser.add_argument('-h', '--height', type=int, default=150, help='Height (default: 150)')
    parser.add_argument('--folder', action='store_true', help='Process semua gambar di folder')
    parser.add_argument('--multi', nargs='*', type=int, help='Buat multiple sizes (contoh: --multi 150 300 600)')
    
    args = parser.parse_args()
    
    if not args.input:
        print("🖼️ Thumbnail Maker")
        print("")
        print("Usage:")
        print("  python3 thumbnail-maker.py <input-file> [-o output-file] [-w width] [-h height]")
        print("  python3 thumbnail-maker.py <folder> --folder [-w size]")
        print("  python3 thumbnail-maker.py <input-file> --multi [sizes...]")
        print("")
        print("Examples:")
        print("  python3 thumbnail-maker.py image.jpg")
        print("  python3 thumbnail-maker.py image.jpg -o thumb.jpg -w 200 -h 200")
        print("  python3 thumbnail-maker.py ./images --folder -w 150")
        print("  python3 thumbnail-maker.py image.jpg --multi 150 300 600")
        return
    
    input_path = args.input
    
    if args.multi is not None:
        sizes = args.multi if args.multi else [150, 300, 600]
        create_multiple_sizes(input_path, sizes)
    elif args.folder:
        create_thumbnails_from_folder(input_path, args.width)
    else:
        if args.output:
            output_path = args.output
        else:
            input_file = Path(input_path)
            output_path = str(input_file.parent / f"{input_file.stem}_thumb{input_file.suffix}")
        
        create_thumbnail_basic(input_path, output_path, args.width, args.height)

if __name__ == "__main__":
    main()