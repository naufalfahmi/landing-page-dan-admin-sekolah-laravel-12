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
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('page_title')->nullable();
            $table->string('ip_address');
            $table->string('user_agent')->nullable();
            $table->string('referer')->nullable();
            $table->string('session_id')->nullable();
            $table->timestamp('viewed_at');
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['url', 'viewed_at']);
            $table->index(['ip_address', 'viewed_at']);
            $table->index('viewed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
