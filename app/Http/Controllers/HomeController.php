<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSetting;
use App\Models\Artist;
use App\Models\Ticket;
use App\Models\Track;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
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

        $tracks = Track::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($track) {
                return [
                    'title' => $track->title,
                    'artist' => $track->artist ?? 'Unknown',
                    // Cek apakah link eksternal atau file lokal
                    'url' => str_starts_with($track->audio_url, 'http') ? $track->audio_url : asset($track->audio_url),
                ];
            });

        $tickets = Ticket::all()->map(function ($ticket) {
            return [
                'id' => $ticket->id,
                'name' => $ticket->name,
                'price' => $ticket->price_display,
                'stock' => $ticket->stock,            
                'is_sold_out' => $ticket->is_sold_out, 
                'features' => $ticket->features ?? [],
                'glow' => (bool) $ticket->is_featured,
                'borderColor' => $ticket->is_featured ? '' : ($ticket->name == 'DEWA / VVIP' ? 'border-yellow-500' : 'border-gray-600'),
                'textColor' => $ticket->name == 'DEWA / VVIP' ? 'text-yellow-500' : 'text-gray-400',
                'icon' => $ticket->is_featured ? 'zap' : ($ticket->name == 'DEWA / VVIP' ? 'crown' : 'skull'),
            ];
        });

        // Kirim semua data ke view
        return view('home', compact('settings', 'artists', 'tickets', 'tracks'));
    }
}