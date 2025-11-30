<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'Transaksi Tiket';
    protected static ?string $modelLabel = 'Transaksi';
    protected static ?string $navigationGroup = 'Penjualan';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Informasi Pembeli')
                            ->schema([
                                // Ganti jadi Placeholder biar aman
                                Forms\Components\Placeholder::make('code')
                                    ->label('Kode Booking')
                                    ->content(fn(Transaction $record): string => $record->code),

                                Forms\Components\Placeholder::make('guest_name')
                                    ->label('Nama Pemesan')
                                    ->content(fn(Transaction $record): string => $record->guest_name),

                                Forms\Components\Placeholder::make('guest_email')
                                    ->label('Email')
                                    ->content(fn(Transaction $record): string => $record->guest_email),

                                Forms\Components\Placeholder::make('guest_phone')
                                    ->label('No WhatsApp')
                                    ->content(fn(Transaction $record): string => $record->guest_phone),
                            ])->columns(2),

                        Forms\Components\Section::make('Detail Pembayaran')
                            ->schema([
                                // Status tetep Select karena mau diedit admin
                                Forms\Components\Select::make('status')
                                    ->label('Status Transaksi')
                                    ->options([
                                        'pending' => 'Belum Bayar',
                                        'waiting_approval' => 'Menunggu Verifikasi',
                                        'paid' => 'LUNAS (Approved)',
                                        'rejected' => 'Ditolak',
                                    ])
                                    ->required()
                                    ->native(false),

                                Forms\Components\FileUpload::make('payment_proof')
                                    ->label('Bukti Transfer')
                                    ->image()
                                    ->directory('proofs')
                                    ->openable()
                                    ->downloadable()
                                    ->columnSpanFull(),
                            ]),
                    ])->columnSpan(2),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Rincian Tiket')
                            ->schema([
                                // INI FIX UTAMANYA: Pake Placeholder!
                                // Pake content() buat ambil datanya
                                Forms\Components\Placeholder::make('ticket_name')
                                    ->label('Jenis Tiket')
                                    ->content(fn(Transaction $record): string => $record->ticket->name ?? '-'),

                                Forms\Components\Placeholder::make('quantity')
                                    ->label('Jumlah Tiket')
                                    ->content(fn(Transaction $record): string => $record->quantity . ' Tiket'),

                                Forms\Components\Placeholder::make('unique_code')
                                    ->label('Kode Unik')
                                    ->content(fn(Transaction $record): string => $record->unique_code),

                                Forms\Components\Placeholder::make('total_price')
                                    ->label('Total Transfer')
                                    ->content(fn(Transaction $record): string => 'Rp ' . number_format($record->total_price, 0, ',', '.')),
                            ]),
                    ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode')
                    ->searchable()
                    ->copyable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('guest_name')
                    ->label('Nama')
                    ->searchable(),

                Tables\Columns\TextColumn::make('ticket.name')
                    ->label('Tiket')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'gray',
                        'waiting_approval' => 'warning',
                        'paid' => 'success',
                        'rejected' => 'danger',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'Belum Bayar',
                        'waiting_approval' => 'Cek Bukti',
                        'paid' => 'Lunas',
                        'rejected' => 'Ditolak',
                        default => $state,
                    }),

                Tables\Columns\ImageColumn::make('payment_proof')
                    ->label('Bukti')
                    ->circular(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Belum Bayar',
                        'waiting_approval' => 'Menunggu Verifikasi',
                        'paid' => 'Lunas',
                        'rejected' => 'Ditolak',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}