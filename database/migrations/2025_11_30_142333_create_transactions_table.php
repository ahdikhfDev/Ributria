<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            
            // Kode Unik
            $table->string('code')->unique(); // TRX-XXXX
            $table->string('ticket_code')->nullable()->unique(); // TKT-XXXX (Baru muncul pas lunas)
            
            // Data Pembeli
            $table->string('guest_name');
            $table->string('guest_email');
            $table->string('guest_phone');
            
            // Data Tiket
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->integer('total_price');
            $table->integer('unique_code'); 
            
            // Bukti Bayar & Status
            $table->string('payment_proof')->nullable();
            $table->enum('status', ['pending', 'waiting_approval', 'paid', 'rejected'])->default('pending');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};