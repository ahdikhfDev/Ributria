<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\SiteSetting;
use App\Models\Artist;
use App\Models\Track;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    // ... (Fungsi Checkout, ShowPayment, UploadProof TETAP SAMA / Jangan Dihapus) ...
    public function checkout(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:20',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $ticket = Ticket::find($request->ticket_id);

        $priceClean = 0;
        $priceString = strtoupper($ticket->price_display);

        if (str_contains($priceString, 'K')) {
            $angka = preg_replace('/[^0-9]/', '', $priceString);
            $priceClean = (int) $angka * 1000;
        } else {
            $priceClean = (int) preg_replace('/[^0-9]/', '', $priceString);
        }

        if ($priceClean == 0) {
            if (str_contains($ticket->name, 'ROOKIE'))
                $priceClean = 750000;
            if (str_contains($ticket->name, 'VIP'))
                $priceClean = 1500000;
            if (str_contains($ticket->name, 'DEWA'))
                $priceClean = 3000000;
        }

        $uniqueCode = rand(100, 999);
        $totalPrice = ($priceClean * $request->quantity) + $uniqueCode;

        // Gunakan trim() saat simpan biar data baru gak error lagi
        $transaction = Transaction::create([
            'code' => 'TRX-' . strtoupper(Str::random(6)),
            'ticket_id' => $ticket->id,
            'guest_name' => $request->guest_name,
            'guest_email' => $request->guest_email,
            'guest_phone' => $request->guest_phone,
            'quantity' => $request->quantity,
            'unique_code' => $uniqueCode,
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);

        return redirect()->route('payment.show', $transaction->code);
    }

    public function showPayment($code)
    {
        // Pakai LIKE juga di sini biar link pembayaran gak 404 kalau dicopy ada spasinya
        $transaction = Transaction::where('code', 'LIKE', $code . '%')->with('ticket')->firstOrFail();

        $settings = SiteSetting::first();
        if (!$settings)
            $settings = new SiteSetting(['primary_color' => '#ff1f1f', 'secondary_color' => '#ccff00', 'background_color' => '#050505']);

        $artists = Artist::where('is_active', true)->orderBy('sort_order')->get()->map(function ($artist) {
            return [
                'name' => $artist->name,
                'genre' => $artist->genre,
                'img' => $artist->image ? Storage::url($artist->image) : 'https://placehold.co/600x800/111/FFF?text=' . urlencode($artist->name),
            ];
        });

        $tracks = Track::where('is_active', true)->orderBy('sort_order')->get()->map(function ($track) {
            return [
                'title' => $track->title,
                'artist' => $track->artist ?? 'Unknown',
                'url' => str_starts_with($track->audio_url, 'http') ? $track->audio_url : asset($track->audio_url),
            ];
        });

        $tickets = Ticket::all()->map(function ($ticket) {
            return [
                'id' => $ticket->id,
                'name' => $ticket->name,
                'price' => $ticket->price_display,
                'features' => $ticket->features ?? [],
                'glow' => (bool) $ticket->is_featured,
                'borderColor' => $ticket->is_featured ? '' : ($ticket->name == 'DEWA / VVIP' ? 'border-yellow-500' : 'border-gray-600'),
                'textColor' => $ticket->name == 'DEWA / VVIP' ? 'text-yellow-500' : 'text-gray-400',
                'icon' => $ticket->is_featured ? 'zap' : ($ticket->name == 'DEWA / VVIP' ? 'crown' : 'skull'),
            ];
        });

        return view('payment', compact('transaction', 'settings', 'artists', 'tracks', 'tickets'));
    }

    public function uploadProof(Request $request, $code)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $transaction = Transaction::where('code', $code)->firstOrFail();
        $path = $request->file('payment_proof')->store('proofs', 'public');

        $transaction->update([
            'payment_proof' => $path,
            'status' => 'waiting_approval'
        ]);

        return back()->with('success', 'Mantap! Bukti transfer udah masuk. Tunggu admin verifikasi ya!');
    }

    public function checkStatus(Request $request)
    {
        // Ambil input dan trim
        $input = trim($request->input('code'));

        if (empty($input)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Isi dulu kolomnya bro.'
            ], 400);
        }

        // Bersihin input: hapus prefix (TRX-/TKT-), spasi, uppercase
        $cleanInput = strtoupper(str_replace(['TRX-', 'TKT-', ' '], '', $input));

        // Cari di 2 kolom: code (TRX-) atau ticket_code (TKT-)
        $transaction = Transaction::where(function ($query) use ($cleanInput) {
            // Cari di kolom 'code' (booking code)
            $query->whereRaw("REPLACE(REPLACE(UPPER(code), 'TRX-', ''), ' ', '') LIKE ?", ["%{$cleanInput}%"])
                // ATAU di kolom 'ticket_code' (tiket resmi)
                ->orWhereRaw("REPLACE(REPLACE(UPPER(ticket_code), 'TKT-', ''), ' ', '') LIKE ?", ["%{$cleanInput}%"]);
        })
            ->with('ticket')
            ->first();

        // Kalau gak ketemu
        if (!$transaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kode gak ketemu. Cek lagi ya!'
            ], 404);
        }

        // Kalau ketemu, kirim datanya
        return response()->json([
            'status' => 'success',
            'data' => [
                'guest_name' => $transaction->guest_name,
                'ticket_name' => $transaction->ticket->name,
                'status' => $transaction->status,

                // Tiket code cuma muncul kalau udah PAID
                'ticket_code' => ($transaction->status === 'paid') ? $transaction->ticket_code : null,

                'status_label' => match ($transaction->status) {
                    'pending' => 'BELUM BAYAR',
                    'waiting_approval' => 'MENUNGGU VERIFIKASI',
                    'paid' => 'LUNAS (TIKET AMAN)',
                    'rejected' => 'DITOLAK',
                    default => 'UNKNOWN'
                }
            ]
        ]);
    }
}