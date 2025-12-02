<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema; // Import Schema
use App\Models\SiteSetting;
use App\Models\Artist;
use App\Models\Ticket;
use App\Models\Track;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // DISABLE FOREIGN KEY CHECKS (Supaya bisa truncate tabel berelasi)
        Schema::disableForeignKeyConstraints();

        // 1. SEED SITE SETTINGS
        SiteSetting::truncate();
        
        SiteSetting::create([
            'hero_title' => "BISING\nNGERILIS\nJIWA LO",
            'hero_description' => "Sistem tiket konser masa depan. Bukan cuma tiket doang, tapi akses ke dunia audio-visual tanpa batas.\nJangan cuma nonton. Bikin ribut.",
            'primary_color' => '#ff1f1f',
            'secondary_color' => '#ccff00',
            'background_color' => '#050505',
            'location_name' => 'JAKARTA (GBK)',
            'event_date' => now()->addDays(30)->setTime(19, 0, 0),
            'oracle_prompt' => "Kamu adalah AI asisten yang santai banget. Pake bahasa gaul Jakarta Selatan. Sering-sering bilang 'Jujurly' atau 'Which is",
        ]);

        // 2. SEED ARTISTS
        Artist::truncate();

        $artists = [
            [
                'name' => 'RIRIS MULYANTI',
                'genre' => 'INDUSTRIAL NOISE',
                'image' => null, 
                'sort_order' => 1,
            ],
            [
                'name' => 'AHDI KHALIDA FATHIR',
                'genre' => 'SYNTHWAVE',
                'image' => null,
                'sort_order' => 2,
            ],
            [
                'name' => 'LUTFI',
                'genre' => 'GLITCH HOP',
                'image' => null,
                'sort_order' => 3,
            ],
            [
                'name' => 'KEYSA',
                'genre' => 'DARK AMBIENT',
                'image' => null,
                'sort_order' => 4,
            ],
            [
                'name' => 'FAIZ',
                'genre' => 'DARK AMBIENT',
                'image' => null,
                'sort_order' => 5,
            ],
        ];

        foreach ($artists as $artist) {
            Artist::create($artist);
        }

        // 3. SEED TICKETS
        Ticket::truncate();

        $tickets = [
            [
                'name' => 'PEMULA / ROOKIE',
                'price_display' => 'IDR 750K',
                'features' => ['Akses Umum', 'Area Berdiri', '1x Minum Gratis'],
                'is_sold_out' => false,
                'is_featured' => false,
            ],
            [
                'name' => 'RUSUH / VIP',
                'price_display' => 'IDR 1.500K',
                'features' => ['Paling Depan (Moshpit)', 'Masuk Jalur Cepat', 'Toilet VIP', '3x Minum Gratis'],
                'is_sold_out' => false,
                'is_featured' => true,
            ],
            [
                'name' => 'DEWA / VVIP',
                'price_display' => 'IDR 3.000K',
                'features' => ['Box Pribadi', 'Tur Belakang Panggung', 'Ketemu Artis', 'Akses Semua Area'],
                'is_sold_out' => false,
                'is_featured' => false,
            ],
        ];

        foreach ($tickets as $ticket) {
            Ticket::create($ticket);
        }

        // 4. SEED TRACKS
        Track::truncate();

        $tracks = [
            [
                'title' => 'Everything U Are',
                'artist' => 'Hindia',
                'audio_url' => 'https://res.cloudinary.com/dym46ephk/video/upload/v1764423997/Hindia_-_everything_u_are_1_furpk2.mp3',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Synthwave Demo',
                'artist' => 'SoundHelix',
                'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3',
                'is_active' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($tracks as $track) {
            Track::create($track);
        }

        // RE-ENABLE FOREIGN KEY CHECKS (PENTING!)
        Schema::enableForeignKeyConstraints();
    }
}