<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            // Add category_id column
            $table->unsignedBigInteger('category_id')->nullable()->after('id');
            
            // Add foreign key constraint
            $table->foreign('category_id')->references('id')->on('gallery_categories')->onDelete('set null');
            
            // Add index for better performance
            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['category_id']);
            
            // Drop index
            $table->dropIndex(['category_id']);
            
            // Drop column
            $table->dropColumn('category_id');
        });
    }
};
