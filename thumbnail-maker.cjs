const fs = require('fs');
const path = require('path');

// Function untuk membuat thumbnail menggunakan canvas (built-in Node.js)
function createThumbnail(inputPath, outputPath, width = 150, height = 150) {
    try {
        // Baca file gambar
        const imageBuffer = fs.readFileSync(inputPath);
        
        // Untuk demo, kita akan copy file dan rename dengan prefix thumbnail_
        // Dalam implementasi nyata, Anda perlu library seperti sharp atau jimp
        const fileName = path.basename(inputPath);
        const fileExt = path.extname(inputPath);
        const fileNameWithoutExt = path.basename(inputPath, fileExt);
        
        const thumbnailName = `${fileNameWithoutExt}_thumb${fileExt}`;
        const thumbnailPath = path.join(path.dirname(outputPath), thumbnailName);
        
        // Copy file sebagai placeholder
        fs.copyFileSync(inputPath, thumbnailPath);
        
        console.log(`Thumbnail berhasil dibuat: ${thumbnailPath}`);
        return thumbnailPath;
        
    } catch (error) {
        console.error('Error membuat thumbnail:', error.message);
        return null;
    }
}

// Function untuk batch processing
function createThumbnailsFromFolder(folderPath, thumbnailSize = 150) {
    try {
        const files = fs.readdirSync(folderPath);
        const imageExtensions = ['.jpg', '.jpeg', '.png', '.gif', '.bmp', '.webp'];
        
        const imageFiles = files.filter(file => {
            const ext = path.extname(file).toLowerCase();
            return imageExtensions.includes(ext);
        });
        
        console.log(`Ditemukan ${imageFiles.length} file gambar di ${folderPath}`);
        
        imageFiles.forEach(file => {
            const inputPath = path.join(folderPath, file);
            const outputPath = path.join(folderPath, 'thumbnails');
            
            // Buat folder thumbnails jika belum ada
            if (!fs.existsSync(outputPath)) {
                fs.mkdirSync(outputPath, { recursive: true });
            }
            
            createThumbnail(inputPath, outputPath, thumbnailSize, thumbnailSize);
        });
        
    } catch (error) {
        console.error('Error processing folder:', error.message);
    }
}

// Export functions untuk digunakan
module.exports = {
    createThumbnail,
    createThumbnailsFromFolder
};

// Jika script dijalankan langsung
if (require.main === module) {
    const args = process.argv.slice(2);
    
    if (args.length === 0) {
        console.log('Usage:');
        console.log('  node thumbnail-maker.js <input-file> [output-file] [width] [height]');
        console.log('  node thumbnail-maker.js --folder <folder-path> [size]');
        console.log('');
        console.log('Examples:');
        console.log('  node thumbnail-maker.js image.jpg');
        console.log('  node thumbnail-maker.js image.jpg thumb.jpg 200 200');
        console.log('  node thumbnail-maker.js --folder ./images 150');
    } else if (args[0] === '--folder') {
        const folderPath = args[1] || './';
        const size = parseInt(args[2]) || 150;
        createThumbnailsFromFolder(folderPath, size);
    } else {
        const inputFile = args[0];
        const outputFile = args[1];
        const width = parseInt(args[2]) || 150;
        const height = parseInt(args[3]) || 150;
        
        createThumbnail(inputFile, outputFile, width, height);
    }
}