<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            if (Schema::hasColumn('announcements', 'attachment')) {
                $table->dropColumn('attachment');
            }
            if (Schema::hasColumn('announcements', 'attachment_name')) {
                $table->dropColumn('attachment_name');
            }
            if (Schema::hasColumn('announcements', 'attachment_size')) {
                $table->dropColumn('attachment_size');
            }
            if (Schema::hasColumn('announcements', 'attachment_mime')) {
                $table->dropColumn('attachment_mime');
            }
        });
    }

    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            if (!Schema::hasColumn('announcements', 'attachment')) {
                $table->string('attachment')->nullable()->after('priority');
            }
            if (!Schema::hasColumn('announcements', 'attachment_name')) {
                $table->string('attachment_name')->nullable()->after('attachment');
            }
            if (!Schema::hasColumn('announcements', 'attachment_size')) {
                $table->unsignedBigInteger('attachment_size')->nullable()->after('attachment_name');
            }
            if (!Schema::hasColumn('announcements', 'attachment_mime')) {
                $table->string('attachment_mime')->nullable()->after('attachment_size');
            }
        });
    }
};


