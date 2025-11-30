<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. UPDATE SETTINGS (Buat Info Bank Admin)
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('bank_name')->nullable()->after('event_date');
            $table->string('bank_account_number')->nullable()->after('bank_name');
            $table->string('bank_account_name')->nullable()->after('bank_account_number');
            $table->string('qris_image')->nullable()->after('bank_account_name');
        });

        // 2. TABEL TRANSAKSI
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            
            // Kode Booking (TRX-...)
            $table->string('code')->unique(); 
            
            // Kode Tiket Resmi (TKT-...) -> KITA TAMBAHIN LANGSUNG DI SINI
            $table->string('ticket_code')->nullable()->unique(); 
            
            // Data Pembeli (Guest)
            $table->string('guest_name');
            $table->string('guest_email');
            $table->string('guest_phone');
            
            // Data Tiket
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->integer('total_price'); // Harga Total + Kode Unik
            $table->integer('unique_code'); // 3 digit angka uniknya doang
            
            // Bukti Bayar & Status
            $table->string('payment_proof')->nullable();
            $table->enum('status', ['pending', 'waiting_approval', 'paid', 'rejected'])->default('pending');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['bank_name', 'bank_account_number', 'bank_account_name', 'qris_image']);
        });
    }
};