<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Filament\Resources\TransactionResource;

class LatestTransactions extends BaseWidget
{
    // Biar tabelnya lebar memenuhi layar dashboard
    protected int | string | array $columnSpan = 'full'; 
    
    protected static ?string $heading = 'Transaksi Terbaru Masuk';

    // Urutan ke-2, muncul di bawah kotak statistik
    protected static ?int $sort = 2; 

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Transaction::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode')
                    ->weight('bold')
                    ->copyable(),
                
                Tables\Columns\TextColumn::make('guest_name')
                    ->label('Nama Pemesan'),
                
                Tables\Columns\TextColumn::make('ticket.name')
                    ->label('Tiket')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('total_price')
                    ->money('IDR')
                    ->label('Total Transfer'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'waiting_approval' => 'warning',
                        'paid' => 'success',
                        'rejected' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Belum Bayar',
                        'waiting_approval' => 'Cek Bukti',
                        'paid' => 'Lunas',
                        'rejected' => 'Ditolak',
                        default => $state,
                    }),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->since()
                    ->label('Waktu'),
            ])
            ->actions([
                Tables\Actions\Action::make('open')
                    ->label('Proses')
                    ->icon('heroicon-m-pencil-square')
                    ->url(fn (Transaction $record): string => TransactionResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}