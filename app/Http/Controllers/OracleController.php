<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\SiteSetting;
use App\Models\Artist;
use App\Models\Ticket;

class OracleController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $apiKey = env('GEMINI_API_KEY');

        $settings = SiteSetting::first();

        // Fallback kalau database masih kosong (Safety)
        if (!$settings) {
            return response()->json(['reply' => 'Sistem lagi reboot bro (Database kosong). Hubungi Admin.']);
        }

        // Ambil Lineup Artis yang aktif dari DB
        $artists = Artist::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($artist) {
                return "- {$artist->name} (Genre: {$artist->genre})";
            })->implode("\n");

        // Ambil Data Tiket & Stok dari DB
        $tickets = Ticket::all()
            ->map(function ($ticket) {
                $status = ($ticket->is_sold_out || $ticket->stock <= 0) ? '[SOLD OUT]' : '[TERSEDIA]';
                $features = is_array($ticket->features) ? implode(', ', $ticket->features) : $ticket->features;
                return "- {$ticket->name}: {$ticket->price_display} (Stok: {$ticket->stock}) {$status} \n  Benefit: {$features}";
            })->implode("\n");

        $context = "
        FAKTA TERBARU EVENT 'RiButRiA' (Gunakan ini sebagai sumber kebenaran):
        
        A. LOKASI & WAKTU:
           - Lokasi: {$settings->location_name}
           - Tanggal: {$settings->event_date}
        
        B. LINEUP ARTIS SAAT INI:
           {$artists}
        
        C. INFO TIKET & HARGA:
           {$tickets}
        ";

        $adminDefinedPersona = $settings->oracle_prompt ?? "You are 'The Oracle', hype-man for RiButRiA festival.";

        $systemPrompt = "
        PERAN KAMU:
        {$adminDefinedPersona}

        DATA FAKTA REAL-TIME:
        {$context}

        INSTRUKSI TAMBAHAN:
        - Jawab pertanyaan user hanya berdasarkan DATA FAKTA di atas.
        - JANGAN HALUSINASI tentang artis atau harga tiket yang tidak ada di data.
        - Jika user bertanya tiket, jelaskan benefitnya dan status ketersediaannya.
        - Gunakan format bullet points (-) untuk list agar mudah dibaca.
        - JANGAN gunakan simbol bintang (*) untuk bold, gunakan HURUF KAPITAL untuk penekanan.
        ";

        // KIRIM KE GEMINI
        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-preview-09-2025:generateContent?key={$apiKey}", [
                    'contents' => [
                        ['parts' => [['text' => $request->message]]]
                    ],
                    'systemInstruction' => [
                        'parts' => [['text' => $systemPrompt]]
                    ]
                ]);

            $reply = $response->json('candidates.0.content.parts.0.text') ?? 'Sinyal ke server putus bro. Coba teriak lagi!';
        } catch (\Exception $e) {
            $reply = "Waduh, sistem AI lagi overload nih. Coba lagi nanti ya.";
        }

        return response()->json(['reply' => $reply]);
    }
}