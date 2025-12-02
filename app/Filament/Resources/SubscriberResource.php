<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriberResource\Pages;
use App\Models\Subscriber;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SubscriberResource extends Resource
{
    protected static ?string $model = Subscriber::class;

    protected static ?string $navigationIcon = 'heroicon-o-users'; 
    protected static ?string $navigationLabel = 'List Email'; 
    protected static ?string $modelLabel = 'Subscriber';
    protected static ?string $navigationGroup = 'Marketing';

    public static function canCreate(): bool { return false; } 

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->label('Email User')
                    ->searchable()
                    ->copyable() // Biar gampang copas
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-m-envelope'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Join')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc') 
            ->actions([
                Tables\Actions\DeleteAction::make(), 
            ]);
    }
    
    public static function getRelations(): array { return []; }
    
    public static function getPages(): array 
    { 
        return [
            'index' => Pages\ListSubscribers::route('/'),
        ]; 
    }
}