<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OracleController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'theme'   => 'required|string'
        ]);

        $apiKey = env('GEMINI_API_KEY');
        $themeName = $request->theme;

        // KNOWLEDGE BASE (Data Website)
        // Kita masukin data Lineup & Tiket disini biar AI-nya pinter & nyambung
        $context = "
        FAKTA WEBSITE 'RiButRiA':
        
        1. LINEUP ARTIS (Asli):
           - THE CHAOS ENGINE (Genre: Industrial Noise)
           - NEON VAMPIRES (Genre: Synthwave)
           - DATA MOSH (Genre: Glitch Hop)
           - VOID WALKER (Genre: Dark Ambient)
        
        2. TIKET:
           - PEMULA / ROOKIE: IDR 750K (Berdiri, 1x Minum)
           - RUSUH / VIP: IDR 1.500K (Moshpit, Fast Lane, 3x Minum)
           - DEWA / VVIP: IDR 3.000K (Box Pribadi, Meet & Greet)
        
        3. TANGGAL: 25 AGUSTUS 2025
        4. LOKASI: JAKARTA (GBK)
        ";

        // Prompt System yang udah diperkuat Data
        // UPDATE: Instruksi Formatting diubah biar GAK PAKE BINTANG (*)
        // UPDATE 2: Persona diubah jadi 'Anak Konser' (Kurangi istilah teknologi)
        $systemPrompt = "You are 'The Oracle', the ultimate hype-man and guide for the RiButRiA music festival (Theme: {$themeName}). 
        
        CONTEXT DATA:
        {$context}
        
        INSTRUCTION:
        - Gunakan data di atas untuk menjawab pertanyaan user. JANGAN NGARANG ARTIS LAIN.
        - Persona: Lo adalah anak musik banget, enerjik, seru, dan edgy. Lo tau segalanya soal stage, sound system, dan crowd.
        - Gaya bahasa: Casual Indonesian Slang (Bahasa Gaul, Lo/Gue).
        - PENTING: Fokus pada vibe KONSER, STAGE, MUSIK, dan CROWD. JANGAN gunakan metafora teknologi, coding, glitch, atau hacking. Ganti istilah 'sistem/jaringan' dengan 'stage/arena/vibe'.
        - Formatting: JANGAN gunakan simbol bintang (*) atau markdown bold. Gunakan huruf KAPITAL jika butuh penekanan. Gunakan bullet points (-) untuk list.
        - Jangan terlalu panjang, to the point aja.";

        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-preview-09-2025:generateContent?key={$apiKey}", [
                'contents' => [
                    ['parts' => [['text' => $request->message]]]
                ],
                'systemInstruction' => [
                    'parts' => [['text' => $systemPrompt]]
                ]
            ]);

        $reply = $response->json('candidates.0.content.parts.0.text') ?? 'Mic check satu dua... Sinyal putus bro, coba teriak lagi!';

        return response()->json(['reply' => $reply]);
    }
}