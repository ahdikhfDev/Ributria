<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\SiteSetting;
use App\Models\Artist;
use App\Models\Ticket;
use App\Models\Track;

class HindiaThemeSeeder extends Seeder
{
    public function run(): void
    {
        // MATIKAN FOREIGN KEY CHECK BIAR AMAN PAS TRUNCATE
        Schema::disableForeignKeyConstraints();

        // 1. SITE SETTINGS (Vibe: Gloomy & Deep)
        SiteSetting::truncate();
        
        SiteSetting::create([
            // Judul Puitis
            'hero_title' => "LAGIPULA\nHIDUP AKAN\nBERAKHIR",
            
            // Deskripsi ala Baskara
            'hero_description' => "Rayakan ketidaksempurnaan, menangis secukupnya, lalu kembali berjalan. Ini bukan sekadar konser, ini adalah sesi terapi massal untuk jiwa yang lelah.",
            
            // Warna Tema: Biru Laut Dalam & Oranye Senja
            'primary_color' => '#3b82f6',   // Blue 500 (Melancholy)
            'secondary_color' => '#f97316', // Orange 500 (Hope)
            'background_color' => '#0f172a', // Slate 900 (Dark Blueish Black)
            
            'location_name' => 'ISTORA SENAYAN',
            'event_date' => now()->addDays(45)->setTime(18, 30, 0), // Mulai pas senja
            'footer_coordinates' => '-6.2196° S, 106.8014° E',
            
            // Visual Tiket Custom
            'ticket_label_top' => 'TERAPI SESI 01',
            'ticket_label_title' => 'MENARI DENGAN BAYANGAN',
            'ticket_label_bottom' => 'JANGAN LUPA PULANG',
            'ticket_label_left' => 'EVAKUASI',
            'ticket_price_label' => 'MAHAR',
            'ticket_price_display' => 'Rp 350rb++',

            // Bank Info (Opsional)
            'bank_name' => 'BCA',
            'bank_account_number' => '8830-1234-5678',
            'bank_account_name' => 'SUN EATER OFFICIAL',

            // AI Persona: Baskara Putra
            'oracle_prompt' => "You are 'Baskara', the contemplative and poetic soul behind this event. 
            
            Persona: Deep, puitis, realistis, kadang sedikit sinis tapi peduli. Lo ngomong kayak lirik lagu Hindia.
            Gaya bahasa: Casual Jakarta, pake 'Lo/Gue', sering pake metafora.
            
            Instruction: Kalau user nanya tiket, bilang 'Investasi buat kesehatan mental lo'. Kalau nanya lineup, bilang 'Mereka yang bakal nemenin lo nangis'.",
        ]);

        // 2. ARTISTS (Sirkel Sun Eater & Indie Pop)
        Artist::truncate();

        $artists = [
            [
                'name' => 'HINDIA',
                'genre' => 'POP / ALTERNATIF',
                'image' => null, 
                'sort_order' => 1,
            ],
            [
                'name' => '.FEAST',
                'genre' => 'STONER ROCK',
                'image' => null,
                'sort_order' => 2,
            ],
            [
                'name' => 'LOMBA SIHIR',
                'genre' => 'POP SIHIR',
                'image' => null,
                'sort_order' => 3,
            ],
            [
                'name' => 'KUNTO AJI',
                'genre' => 'SOUL / HEALING',
                'image' => null,
                'sort_order' => 4,
            ],
        ];

        foreach ($artists as $artist) {
            Artist::create($artist);
        }

        // 3. TICKETS (Nama Paket Unik)
        Ticket::truncate();

        $tickets = [
            [
                'name' => 'EVALUASI (FESTIVAL)',
                'price_display' => 'IDR 350K',
                'stock' => 500,
                'features' => ['Akses Festival', 'Free Tissue (Buat Nangis)', 'Area Berdiri'],
                'is_sold_out' => false,
                'is_featured' => false,
            ],
            [
                'name' => 'SECUKUPNYA (VIP)',
                'price_display' => 'IDR 650K',
                'stock' => 200,
                'features' => ['Front Row', 'Fast Lane', 'Merchandise Eksklusif', 'Akses Toilet VIP'],
                'is_sold_out' => false,
                'is_featured' => true, // Highlight
            ],
            [
                'name' => 'MEMBASUH (VVIP)',
                'price_display' => 'IDR 1.200K',
                'stock' => 50,
                'features' => ['Meet & Greet', 'Signed Vinyl', 'Duduk di Tribun Sofa', 'Akses Backstage'],
                'is_sold_out' => false,
                'is_featured' => false,
            ],
        ];

        foreach ($tickets as $ticket) {
            Ticket::create($ticket);
        }

        // 4. TRACKS (Lagu Galau)
        Track::truncate();

        $tracks = [
            [
                'title' => 'Evaluasi',
                'artist' => 'Hindia',
                'audio_url' => 'https://res.cloudinary.com/dym46ephk/video/upload/v1764423997/Hindia_-_everything_u_are_1_furpk2.mp3', // Contoh link (bisa diganti)
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Rumah ke Rumah',
                'artist' => 'Hindia',
                'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-8.mp3', // Placeholder
                'is_active' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($tracks as $track) {
            Track::create($track);
        }

        // HIDUPKAN LAGI FOREIGN KEY
        Schema::enableForeignKeyConstraints();
    }
}