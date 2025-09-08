<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing galleries to use category_id instead of category string
        $categoryMapping = [
            'kegiatan-belajar' => 1,
            'ekstrakurikuler' => 2,
            'acara-sekolah' => 3,
            'fasilitas' => 4,
        ];

        foreach ($categoryMapping as $oldCategory => $newCategoryId) {
            DB::table('galleries')
                ->where('category', $oldCategory)
                ->update(['category_id' => $newCategoryId]);
        }

        // Remove the old category column
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back the category column
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('category')->nullable()->after('thumbnail');
        });

        // Restore category data from category_id
        $categoryMapping = [
            1 => 'kegiatan-belajar',
            2 => 'ekstrakurikuler',
            3 => 'acara-sekolah',
            4 => 'fasilitas',
        ];

        foreach ($categoryMapping as $categoryId => $oldCategory) {
            DB::table('galleries')
                ->where('category_id', $categoryId)
                ->update(['category' => $oldCategory]);
        }

        // Set category_id to null
        DB::table('galleries')->update(['category_id' => null]);
    }
};
