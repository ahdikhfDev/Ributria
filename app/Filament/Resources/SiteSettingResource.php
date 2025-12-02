<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Pengaturan Web';
    protected static ?string $navigationGroup = 'System';

    public static function canCreate(): bool
    {
        return SiteSetting::count() === 0;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Hero Section & Teks')
                    ->schema([
                        Forms\Components\TextInput::make('hero_title')
                            ->label('Judul Besar')
                            ->default('BISING NGERILIS JIWA LO')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('hero_description')
                            ->label('Deskripsi Pendek')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Visual Tiket (Hiasan Hero)')
                    ->description('Atur teks yang muncul di gambar tiket 3D di halaman depan.')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('ticket_label_top')
                                ->label('Label Atas')
                                ->default('PUSAT SENI'),

                            Forms\Components\TextInput::make('ticket_label_title')
                                ->label('Label Judul (Tengah)')
                                ->default('BISING NGERILIS...')
                                ->placeholder('BISING NGERILIS...'),

                            Forms\Components\TextInput::make('ticket_label_bottom')
                                ->label('Label Bawah')
                                ->default('TAMPIL LIVE'),

                            Forms\Components\TextInput::make('ticket_label_left')
                                ->label('Label Kiri (Vertical)')
                                ->default('BISING NGE')
                                ->placeholder('BISING NGE'),

                            Forms\Components\TextInput::make('ticket_price_label')
                                ->label('Label Harga')
                                ->default('HARGA'),

                            Forms\Components\TextInput::make('ticket_price_display')
                                ->label('Tampilan Harga')
                                ->default('Rp 750K++'),
                        ]),
                    ]),

                Forms\Components\Section::make('Tema Warna')
                    ->description('Ubah nuansa website langsung dari sini.')
                    ->schema([
                        Forms\Components\ColorPicker::make('primary_color')
                            ->label('Warna Utama (Neon)')
                            ->required(),

                        Forms\Components\ColorPicker::make('secondary_color')
                            ->label('Warna Sekunder')
                            ->required(),

                        Forms\Components\ColorPicker::make('background_color')
                            ->label('Warna Background')
                            ->default('#050505')
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Info Event')
                    ->schema([
                        Forms\Components\TextInput::make('location_name')
                            ->label('Nama Lokasi')
                            ->default('JAKARTA (GBK)'),

                        // FIELD BARU: KOORDINAT PETA
                        Forms\Components\TextInput::make('footer_coordinates')
                            ->label('Koordinat Peta (Footer)')
                            ->default('-6.2088° S, 106.8456° E')
                            ->placeholder('-6.2088° S, 106.8456° E'),

                        Forms\Components\DateTimePicker::make('event_date')
                            ->label('Waktu Event Mulai (Tanggal & Jam)')
                            ->seconds(false)
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Rekening & Pembayaran')
                    ->schema([
                        Forms\Components\TextInput::make('bank_name')
                            ->label('Nama Bank')
                            ->placeholder('Contoh: BCA'),

                        Forms\Components\TextInput::make('bank_account_number')
                            ->label('Nomor Rekening'),

                        Forms\Components\TextInput::make('bank_account_name')
                            ->label('Atas Nama'),

                        Forms\Components\FileUpload::make('qris_image')
                            ->label('Upload Gambar QRIS')
                            ->image()
                            ->directory('payments')
                            ->deleteUploadedFileUsing(function ($file) {
                                Storage::disk('public')->delete($file);
                            })
                            ->columnSpanFull(),
                    ])->columns(3),

                Forms\Components\Section::make('Konfigurasi AI (Oracle)')
                    ->schema([
                        Forms\Components\Textarea::make('oracle_prompt')
                            ->label('System Prompt (Kepribadian AI)')
                            ->rows(5)
                            ->default("You are 'The Oracle', hype-man for RiButRiA festival."),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('hero_title')->label('Judul Web')->limit(30),
                Tables\Columns\ColorColumn::make('primary_color')->label('Warna Utama'),
                Tables\Columns\TextColumn::make('event_date')->dateTime()->label('Waktu Event'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}
