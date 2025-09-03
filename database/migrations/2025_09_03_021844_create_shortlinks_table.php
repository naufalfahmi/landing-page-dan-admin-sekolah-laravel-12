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
        Schema::create('shortlinks', function (Blueprint $table) {
            $table->id();
            $table->string('short_code', 10)->unique(); // Kode pendek seperti MSadx2FS
            $table->string('target_url'); // URL target lengkap
            $table->string('article_id')->nullable(); // ID artikel (opsional)
            $table->integer('clicks')->default(0); // Jumlah klik
            $table->timestamp('expires_at')->nullable(); // Expiry date (opsional)
            $table->timestamps();
            
            // Index untuk performa
            $table->index('short_code');
            $table->index('article_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shortlinks');
    }
};
