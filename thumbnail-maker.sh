#!/bin/bash

# Thumbnail Maker Script
# Membuat thumbnail dari gambar menggunakan berbagai tools

# Colors untuk output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function untuk membuat thumbnail dengan ImageMagick
create_thumbnail_imagemagick() {
    local input_file="$1"
    local output_file="$2"
    local width="$3"
    local height="$4"
    
    if command -v convert &> /dev/null; then
        convert "$input_file" -resize "${width}x${height}^" -gravity center -crop "${width}x${height}+0+0" "$output_file"
        echo -e "${GREEN}✅ Thumbnail berhasil dibuat dengan ImageMagick: $output_file${NC}"
        return 0
    else
        echo -e "${RED}❌ ImageMagick tidak tersedia${NC}"
        return 1
    fi
}

# Function untuk membuat thumbnail dengan sips (macOS built-in)
create_thumbnail_sips() {
    local input_file="$1"
    local output_file="$2"
    local width="$3"
    local height="$4"
    
    if command -v sips &> /dev/null; then
        sips -z "$height" "$width" "$input_file" --out "$output_file" &> /dev/null
        if [ $? -eq 0 ]; then
            echo -e "${GREEN}✅ Thumbnail berhasil dibuat dengan sips: $output_file${NC}"
            return 0
        else
            echo -e "${RED}❌ Error membuat thumbnail dengan sips${NC}"
            return 1
        fi
    else
        echo -e "${RED}❌ sips tidak tersedia${NC}"
        return 1
    fi
}

# Function untuk membuat thumbnail (mencoba berbagai tools)
create_thumbnail() {
    local input_file="$1"
    local output_file="$2"
    local width="${3:-150}"
    local height="${4:-150}"
    
    # Cek apakah file input ada
    if [ ! -f "$input_file" ]; then
        echo -e "${RED}❌ File tidak ditemukan: $input_file${NC}"
        return 1
    fi
    
    # Buat direktori output jika belum ada
    mkdir -p "$(dirname "$output_file")"
    
    # Coba ImageMagick dulu, lalu sips
    if create_thumbnail_imagemagick "$input_file" "$output_file" "$width" "$height"; then
        return 0
    elif create_thumbnail_sips "$input_file" "$output_file" "$width" "$height"; then
        return 0
    else
        echo -e "${RED}❌ Tidak ada tool yang tersedia untuk membuat thumbnail${NC}"
        echo -e "${YELLOW}💡 Install ImageMagick: brew install imagemagick${NC}"
        return 1
    fi
}

# Function untuk batch processing
create_thumbnails_from_folder() {
    local folder_path="$1"
    local thumbnail_size="${2:-150}"
    
    if [ ! -d "$folder_path" ]; then
        echo -e "${RED}❌ Folder tidak ditemukan: $folder_path${NC}"
        return 1
    fi
    
    # Ekstensi gambar yang didukung
    local image_extensions="jpg jpeg png gif bmp webp"
    local count=0
    
    # Buat folder thumbnails
    local thumbnail_dir="$folder_path/thumbnails"
    mkdir -p "$thumbnail_dir"
    
    echo -e "${BLUE}📁 Mencari gambar di: $folder_path${NC}"
    
    # Process setiap file gambar
    for ext in $image_extensions; do
        # Check lowercase
        for file in "$folder_path"/*."$ext"; do
            if [ -f "$file" ]; then
                local filename=$(basename "$file")
                local name_without_ext="${filename%.*}"
                local extension="${filename##*.}"
                local output_file="$thumbnail_dir/${name_without_ext}_thumb.$extension"
                
                echo -e "${YELLOW}🔄 Processing: $filename${NC}"
                create_thumbnail "$file" "$output_file" "$thumbnail_size" "$thumbnail_size"
                ((count++))
            fi
        done
        # Check uppercase
        for file in "$folder_path"/*."$(echo $ext | tr '[:lower:]' '[:upper:]')"; do
            if [ -f "$file" ]; then
                local filename=$(basename "$file")
                local name_without_ext="${filename%.*}"
                local extension="${filename##*.}"
                local output_file="$thumbnail_dir/${name_without_ext}_thumb.$extension"
                
                echo -e "${YELLOW}🔄 Processing: $filename${NC}"
                create_thumbnail "$file" "$output_file" "$thumbnail_size" "$thumbnail_size"
                ((count++))
            fi
        done
    done
    
    echo -e "${GREEN}🎉 Selesai! Diproses $count file gambar${NC}"
    echo -e "${GREEN}📁 Thumbnail tersimpan di: $thumbnail_dir${NC}"
}

# Function untuk membuat multiple sizes
create_multiple_sizes() {
    local input_file="$1"
    shift
    local sizes=("$@")
    
    if [ ${#sizes[@]} -eq 0 ]; then
        sizes=(150 300 600)
    fi
    
    for size in "${sizes[@]}"; do
        local filename=$(basename "$input_file")
        local name_without_ext="${filename%.*}"
        local extension="${filename##*.}"
        local output_file="$(dirname "$input_file")/${name_without_ext}_${size}x${size}.$extension"
        
        echo -e "${YELLOW}🔄 Membuat thumbnail ${size}x${size}${NC}"
        create_thumbnail "$input_file" "$output_file" "$size" "$size"
    done
}

# Main function
main() {
    if [ $# -eq 0 ]; then
        echo -e "${BLUE}🖼️ Thumbnail Maker${NC}"
        echo ""
        echo "Usage:"
        echo "  $0 <input-file> [output-file] [width] [height]"
        echo "  $0 <folder> --folder [size]"
        echo "  $0 <input-file> --multi [sizes...]"
        echo ""
        echo "Examples:"
        echo "  $0 image.jpg"
        echo "  $0 image.jpg thumb.jpg 200 200"
        echo "  $0 ./images --folder 150"
        echo "  $0 image.jpg --multi 150 300 600"
        echo ""
        echo "Available tools:"
        if command -v convert &> /dev/null; then
            echo -e "  ${GREEN}✅ ImageMagick (convert)${NC}"
        else
            echo -e "  ${RED}❌ ImageMagick (convert) - Install: brew install imagemagick${NC}"
        fi
        if command -v sips &> /dev/null; then
            echo -e "  ${GREEN}✅ sips (macOS built-in)${NC}"
        else
            echo -e "  ${RED}❌ sips (macOS built-in)${NC}"
        fi
        return
    fi
    
    # Check for special flags
    if [ "$2" = "--folder" ]; then
        create_thumbnails_from_folder "$1" "$3"
    elif [ "$2" = "--multi" ]; then
        create_multiple_sizes "$1" "${@:3}"
    else
        create_thumbnail "$1" "$2" "$3" "$4"
    fi
}

# Jalankan main function
main "$@"