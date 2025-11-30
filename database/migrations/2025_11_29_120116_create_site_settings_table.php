<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            
            // --- 1. HERO SECTION ---
            $table->string('hero_title')->default('BISING NGERILIS JIWA LO');
            $table->text('hero_description')->nullable();

            // --- 2. TEMA WARNA ---
            $table->string('primary_color')->default('#ff1f1f');
            $table->string('secondary_color')->default('#ccff00');
            $table->string('background_color')->default('#050505');

            // --- 3. KONFIGURASI AI ---
            $table->text('oracle_prompt')->nullable()->comment('Instruksi kepribadian AI');

            // --- 4. EVENT & LOKASI ---
            $table->string('location_name')->default('JAKARTA (GBK)');
            // Pakai dateTime biar ada jam-nya untuk countdown akurat
            $table->dateTime('event_date')->nullable(); 
            $table->string('footer_coordinates')->default('-6.2088° S, 106.8456° E')->nullable();

            // --- 5. VISUAL TIKET (CUSTOM TEXT) ---
            $table->string('ticket_label_top')->default('PUSAT SENI')->nullable();
            $table->string('ticket_label_title')->default('BISING NGERILIS...')->nullable();
            $table->string('ticket_label_bottom')->default('TAMPIL LIVE')->nullable();
            $table->string('ticket_label_left')->default('BISING NGE')->nullable();
            $table->string('ticket_price_label')->default('HARGA')->nullable();
            $table->string('ticket_price_display')->default('Rp 750K++')->nullable();

            // --- 6. INFO PEMBAYARAN (BANK) ---
            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('qris_image')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};