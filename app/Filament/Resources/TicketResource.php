<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationLabel = 'Tiket Konser';
    protected static ?string $modelLabel = 'Tiket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Paket')
                            ->placeholder('Contoh: RUSUH / VIP')
                            ->required(),
                        
                        Forms\Components\TextInput::make('price_display')
                            ->label('Tampilan Harga')
                            ->placeholder('Contoh: IDR 1.500K')
                            ->required(),

                        // INI YANG LU MINTA: Tags Input buat fitur
                        Forms\Components\TagsInput::make('features')
                            ->label('Benefit / Fitur')
                            ->placeholder('Ketik fitur lalu tekan Enter')
                            ->columnSpanFull(),
                        
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Toggle::make('is_sold_out')
                                    ->label('Status SOLD OUT')
                                    ->onColor('danger'),
                                
                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Highlight (Glow Effect)')
                                    ->helperText('Aktifkan buat tiket paling laris.'),
                            ]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('price_display')
                    ->label('Harga'),
                
                Tables\Columns\IconColumn::make('is_sold_out')
                    ->label('Sold Out')
                    ->boolean()
                    ->trueColor('danger'),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Highlight')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}