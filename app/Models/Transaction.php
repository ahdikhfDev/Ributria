<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

        // 1. AUTO-TRIM sebelum save
        static::saving(function ($transaction) {
            $transaction->code = trim($transaction->code);
            $transaction->guest_email = trim($transaction->guest_email);
            
            if ($transaction->ticket_code) {
                $transaction->ticket_code = trim($transaction->ticket_code);
            }
            
            // 2. AUTO-GENERATE ticket_code kalau status jadi PAID
            if ($transaction->status === 'paid' && empty($transaction->ticket_code)) {
                $transaction->ticket_code = 'TKT-' . strtoupper(Str::random(4)) . rand(1000, 9999);
            }
        });

        // 3. Hapus file bukti bayar kalau transaksi dihapus
        static::deleting(function ($transaction) {
            if ($transaction->payment_proof && \Storage::disk('public')->exists($transaction->payment_proof)) {
                \Storage::disk('public')->delete($transaction->payment_proof);
            }
        });
    }
}