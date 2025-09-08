const fs = require('fs');
const path = require('path');

// Function untuk membuat thumbnail menggunakan sharp
async function createThumbnailSharp(inputPath, outputPath, width = 150, height = 150, quality = 80) {
    try {
        // Cek apakah sharp tersedia
        let sharp;
        try {
            sharp = require('sharp');
        } catch (error) {
            console.log('Sharp belum terinstall. Menginstall sharp...');
            const { execSync } = require('child_process');
            execSync('npm install sharp', { stdio: 'inherit' });
            sharp = require('sharp');
        }
        
        // Buat thumbnail
        await sharp(inputPath)
            .resize(width, height, {
                fit: 'cover',
                position: 'center'
            })
            .jpeg({ quality: quality })
            .toFile(outputPath);
        
        console.log(`✅ Thumbnail berhasil dibuat: ${outputPath}`);
        return outputPath;
        
    } catch (error) {
        console.error('❌ Error membuat thumbnail:', error.message);
        return null;
    }
}

// Function untuk batch processing dengan sharp
async function createThumbnailsFromFolderSharp(folderPath, thumbnailSize = 150, quality = 80) {
    try {
        const files = fs.readdirSync(folderPath);
        const imageExtensions = ['.jpg', '.jpeg', '.png', '.gif', '.bmp', '.webp'];
        
        const imageFiles = files.filter(file => {
            const ext = path.extname(file).toLowerCase();
            return imageExtensions.includes(ext);
        });
        
        console.log(`📁 Ditemukan ${imageFiles.length} file gambar di ${folderPath}`);
        
        // Buat folder thumbnails jika belum ada
        const thumbnailDir = path.join(folderPath, 'thumbnails');
        if (!fs.existsSync(thumbnailDir)) {
            fs.mkdirSync(thumbnailDir, { recursive: true });
        }
        
        // Process setiap file gambar
        for (const file of imageFiles) {
            const inputPath = path.join(folderPath, file);
            const fileName = path.basename(file, path.extname(file));
            const outputPath = path.join(thumbnailDir, `${fileName}_thumb.jpg`);
            
            console.log(`🔄 Processing: ${file}`);
            await createThumbnailSharp(inputPath, outputPath, thumbnailSize, thumbnailSize, quality);
        }
        
        console.log(`🎉 Selesai! Semua thumbnail tersimpan di: ${thumbnailDir}`);
        
    } catch (error) {
        console.error('❌ Error processing folder:', error.message);
    }
}

// Function untuk membuat multiple sizes
async function createMultipleSizes(inputPath, sizes = [150, 300, 600]) {
    try {
        const fileName = path.basename(inputPath, path.extname(inputPath));
        const dirName = path.dirname(inputPath);
        
        for (const size of sizes) {
            const outputPath = path.join(dirName, `${fileName}_${size}x${size}.jpg`);
            await createThumbnailSharp(inputPath, outputPath, size, size);
        }
        
    } catch (error) {
        console.error('❌ Error membuat multiple sizes:', error.message);
    }
}

// Export functions
module.exports = {
    createThumbnailSharp,
    createThumbnailsFromFolderSharp,
    createMultipleSizes
};

// Jika script dijalankan langsung
if (require.main === module) {
    const args = process.argv.slice(2);
    
    if (args.length === 0) {
        console.log('🖼️  Thumbnail Maker dengan Sharp');
        console.log('');
        console.log('Usage:');
        console.log('  node thumbnail-maker-sharp.js <input-file> [output-file] [width] [height] [quality]');
        console.log('  node thumbnail-maker-sharp.js --folder <folder-path> [size] [quality]');
        console.log('  node thumbnail-maker-sharp.js --multi <input-file> [sizes...]');
        console.log('');
        console.log('Examples:');
        console.log('  node thumbnail-maker-sharp.js image.jpg');
        console.log('  node thumbnail-maker-sharp.js image.jpg thumb.jpg 200 200 90');
        console.log('  node thumbnail-maker-sharp.js --folder ./images 150 80');
        console.log('  node thumbnail-maker-sharp.js --multi image.jpg 150 300 600');
    } else if (args[0] === '--folder') {
        const folderPath = args[1] || './';
        const size = parseInt(args[2]) || 150;
        const quality = parseInt(args[3]) || 80;
        createThumbnailsFromFolderSharp(folderPath, size, quality);
    } else if (args[0] === '--multi') {
        const inputFile = args[1];
        const sizes = args.slice(2).map(s => parseInt(s)).filter(s => !isNaN(s));
        if (sizes.length === 0) sizes = [150, 300, 600];
        createMultipleSizes(inputFile, sizes);
    } else {
        const inputFile = args[0];
        const outputFile = args[1];
        const width = parseInt(args[2]) || 150;
        const height = parseInt(args[3]) || 150;
        const quality = parseInt(args[4]) || 80;
        
        createThumbnailSharp(inputFile, outputFile, width, height, quality);
    }
}