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
            $table->string('hero_title')->default('BISING NGERILIS JIWA LO');
            $table->text('hero_description')->nullable();

            // Colors / Theme
            $table->string('primary_color')->default('#ff1f1f');
            $table->string('secondary_color')->default('#ccff00');
            $table->string('background_color')->default('#050505');

            // AI Settings
            $table->text('oracle_prompt')->nullable()->comment('Instruksi kepribadian AI');

            // Footer / Event
            $table->string('location_name')->default('JAKARTA (GBK)');
            $table->date('event_date')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
