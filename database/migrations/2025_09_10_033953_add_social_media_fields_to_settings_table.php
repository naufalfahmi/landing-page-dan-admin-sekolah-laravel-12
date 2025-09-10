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
        // Insert social media settings
        DB::table('settings')->insert([
            [
                'key' => 'instagram_url',
                'value' => '',
                'group' => 'social_media',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'tiktok_url',
                'value' => '',
                'group' => 'social_media',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'facebook_url',
                'value' => '',
                'group' => 'social_media',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'youtube_url',
                'value' => '',
                'group' => 'social_media',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'social_sidebar_enabled',
                'value' => '1',
                'group' => 'social_media',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('settings')->whereIn('key', [
            'instagram_url',
            'tiktok_url', 
            'facebook_url',
            'youtube_url',
            'social_sidebar_enabled'
        ])->delete();
    }
};
