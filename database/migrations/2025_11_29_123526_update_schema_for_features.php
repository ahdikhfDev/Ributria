<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. UPDATE SITE SETTINGS (Ubah Date jadi DateTime biar ada jamnya buat Countdown)
        Schema::table('site_settings', function (Blueprint $table) {
            // Kita drop dulu kolom lama, terus buat baru tipe DateTime
            // (Cara paling aman tanpa perlu install package tambahan)
            $table->dropColumn('event_date');
        });
        
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dateTime('event_date')->nullable()->after('location_name');
        });

        // 2. TABEL TRACKS (Buat Music Player)
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('artist')->nullable();
            $table->string('audio_url'); // Bisa link luar atau path local
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 3. TABEL SUBSCRIBERS (Buat Email Newsletter)
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscribers');
        Schema::dropIfExists('tracks');
        
        // Rollback kolom event_date (balikin ke date biasa)
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn('event_date');
        });
        Schema::table('site_settings', function (Blueprint $table) {
            $table->date('event_date')->nullable();
        });
    }
};