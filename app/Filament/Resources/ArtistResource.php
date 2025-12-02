<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtistResource\Pages;
use App\Models\Artist;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ArtistResource extends Resource
{
    protected static ?string $model = Artist::class;

    protected static ?string $navigationIcon = 'heroicon-o-microphone';
    protected static ?string $navigationLabel = 'Lineup Artis';
    protected static ?string $modelLabel = 'Artis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Profil Artis')
                    ->description('Masukan detail penampil di sini.')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Artis / Band')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('genre')
                            ->label('Genre Musik')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Industrial Noise'),
                        
                        Forms\Components\FileUpload::make('image')
                            ->label('Foto Artis')
                            ->image()
                            ->directory('artists')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Status Tampil')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Tampilkan di Website?')
                            ->default(true),
                        
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0)
                            ->helperText('Angka makin kecil makin di atas.'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Foto'),
                
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('genre')
                    ->searchable(),
                
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),
                
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListArtists::route('/'),
            'create' => Pages\CreateArtist::route('/create'),
            'edit' => Pages\EditArtist::route('/{record}/edit'),
        ];
    }
}