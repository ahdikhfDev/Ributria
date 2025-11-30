<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;

class CleanTransactionCodesSeeder extends Seeder
{
    public function run(): void
    {
        $transactions = Transaction::all();
        
        foreach ($transactions as $trx) {
            // Hapus spasi di code & ticket_code
            $trx->code = trim($trx->code);
            
            if ($trx->ticket_code) {
                $trx->ticket_code = trim($trx->ticket_code);
            }
            
            $trx->saveQuietly(); // Ga trigger event/observer
        }
        
        $this->command->info('✅ ' . $transactions->count() . ' transaksi berhasil dibersihkan!');
    }
}