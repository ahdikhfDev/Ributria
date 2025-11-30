<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Transaction extends Model
{
    protected $guarded = [];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($transaction) {
            // 1. AUTO-TRIM inputan sebelum save
            $transaction->code = trim($transaction->code);
            $transaction->guest_email = trim($transaction->guest_email);
            
            if ($transaction->ticket_code) {
                $transaction->ticket_code = trim($transaction->ticket_code);
            }
            
            // 2. LOGIC SAAT STATUS BERUBAH JADI 'PAID'
            // isDirty('status') memastikan logic ini cuma jalan pas statusnya diganti, bukan pas edit data lain.
            if ($transaction->isDirty('status') && $transaction->status === 'paid') {
                
                // A. Generate Kode Tiket (Jika belum ada)
                if (empty($transaction->ticket_code)) {
                    $transaction->ticket_code = 'TKT-' . strtoupper(Str::random(4)) . rand(1000, 9999);
                }

                // B. KURANGI STOK TIKET (Penting!)
                $ticket = $transaction->ticket;
                if ($ticket) {
                    // Kurangi stok sesuai jumlah pembelian
                    $ticket->decrement('stock', $transaction->quantity);
                    
                    // Cek kalau stok habis, otomatis set flag sold out
                    if ($ticket->fresh()->stock <= 0) {
                        $ticket->update(['is_sold_out' => true]);
                    }
                }
            }
        });

        // 3. Hapus file bukti bayar otomatis kalau transaksi dihapus dari database
        static::deleting(function ($transaction) {
            if ($transaction->payment_proof && Storage::disk('public')->exists($transaction->payment_proof)) {
                Storage::disk('public')->delete($transaction->payment_proof);
            }
        });
    }
}