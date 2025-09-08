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
        // Update existing announcements to use category_id instead of category string
        $categoryMapping = [
            'akademik' => 1,
            'kegiatan' => 2,
            'ujian' => 3,
            'libur' => 4,
            'umum' => 5,
        ];

        foreach ($categoryMapping as $oldCategory => $newCategoryId) {
            DB::table('announcements')
                ->where('category', $oldCategory)
                ->update(['category_id' => $newCategoryId]);
        }

        // Remove the old category column
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back the category column
        Schema::table('announcements', function (Blueprint $table) {
            $table->string('category')->nullable()->after('content');
        });

        // Restore category data from category_id
        $categoryMapping = [
            1 => 'akademik',
            2 => 'kegiatan',
            3 => 'ujian',
            4 => 'libur',
            5 => 'umum',
        ];

        foreach ($categoryMapping as $categoryId => $oldCategory) {
            DB::table('announcements')
                ->where('category_id', $categoryId)
                ->update(['category' => $oldCategory]);
        }

        // Set category_id to null
        DB::table('announcements')->update(['category_id' => null]);
    }
};
