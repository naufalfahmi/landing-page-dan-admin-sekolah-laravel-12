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
        Schema::create('pena_karsa', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt');
            $table->longText('content');
            $table->string('image')->nullable();
            $table->string('author_name'); // Nama penulis (siswa/guru)
            $table->string('author_type')->default('student'); // student, teacher, guest
            $table->string('author_class')->nullable(); // Kelas untuk siswa
            $table->string('author_position')->nullable(); // Jabatan untuk guru
            $table->string('type')->default('article'); // article, opinion, essay, motivation, creative
            $table->string('status')->default('published'); // published, draft, archived
            $table->integer('views')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->json('tags')->nullable(); // Tag untuk kategorisasi
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('slug');
            $table->index('status');
            $table->index('author_type');
            $table->index('type');
            $table->index('published_at');
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pena_karsa');
    }
};
