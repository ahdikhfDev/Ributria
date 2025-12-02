<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use App\Models\Subscriber;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    // Atur refresh otomatis tiap 10 detik biar real-time
    protected static ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        // Hitung Total Pendapatan (Hanya yang PAID)
        $totalRevenue = Transaction::where('status', 'paid')->sum('total_price');

        // Hitung Transaksi yang perlu dicek (Waiting Approval)
        $waitingApproval = Transaction::where('status', 'waiting_approval')->count();

        // Hitung Total Tiket Terjual (Paid Only)
        $ticketsSold = Transaction::where('status', 'paid')->sum('quantity');

        // Hitung Total Email Masuk
        $subscribers = Subscriber::count();

        return [
            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Uang masuk (Lunas)')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->chart([7, 2, 10, 3, 15, 4, 17]) // Grafik hiasan
                ->color('success'),

            Stat::make('Butuh Verifikasi', $waitingApproval)
                ->description('Cek bukti transfer sekarang!')
                ->descriptionIcon('heroicon-m-bell-alert')
                ->color($waitingApproval > 0 ? 'danger' : 'gray') // Merah kalau ada kerjaan
                ->chart([2, 5, 2, 6, 2, 5, 2]),

            Stat::make('Tiket Terjual', $ticketsSold)
                ->description('Total tiket laku')
                ->descriptionIcon('heroicon-m-ticket')
                ->color('primary'),

            Stat::make('Fans Terdaftar', $subscribers)
                ->description('Total Email Newsletter')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
        ];
    }
}