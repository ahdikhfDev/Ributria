<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSetting;
use App\Models\Artist;
use App\Models\Ticket;
use App\Models\Track; // Jangan lupa import Model Track
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Ambil Settingan
        $settings = SiteSetting::first();
        if (!$settings) {
            $settings = new SiteSetting([
                'hero_title' => 'BISING NGERILIS JIWA LO',
                'primary_color' => '#ff1f1f',
                'secondary_color' => '#ccff00',
                'background_color' => '#050505',
                'location_name' => 'JAKARTA (GBK)',
                'event_date' => now()->addDays(30), 
            ]);
        }

        // 2. Ambil Artis
        $artists = Artist::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($artist) {
                return [
                    'name' => $artist->name,
                    'genre' => $artist->genre,
                    'img' => $artist->image ? Storage::url($artist->image) : 'https://placehold.co/600x800/111/FFF?text=' . urlencode($artist->name),
                ];
            });

        // 3. AMBIL LAGU (Playlist) - BARU
        $tracks = Track::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($track) {
                return [
                    'title' => $track->title,
                    'artist' => $track->artist ?? 'Unknown',
                    // Cek: kalau link http pake langsung, kalau file lokal pake asset()
                    'url' => str_starts_with($track->audio_url, 'http') ? $track->audio_url : asset($track->audio_url),
                ];
            });

        // 4. Ambil Tiket
        $tickets = Ticket::all()->map(function ($ticket) {
            return [
                'name' => $ticket->name,
                'price' => $ticket->price_display, 
                'features' => $ticket->features ?? [],
                'glow' => (bool) $ticket->is_featured,
                'borderColor' => $ticket->is_featured ? '' : ($ticket->name == 'DEWA / VVIP' ? 'border-yellow-500' : 'border-gray-600'),
                'textColor' => $ticket->name == 'DEWA / VVIP' ? 'text-yellow-500' : 'text-gray-400',
                'icon' => $ticket->is_featured ? 'zap' : ($ticket->name == 'DEWA / VVIP' ? 'crown' : 'skull'),
            ];
        });

        // Kirim $tracks ke view
        return view('home', compact('settings', 'artists', 'tickets', 'tracks'));
    }
}