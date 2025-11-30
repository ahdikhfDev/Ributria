<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber; // Pastikan ini yang dipakai

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'email' => 'required|email'
        ]);

        // 2. Simpan ke Database (Subscriber)
        // firstOrCreate mencegah duplikat email
        Subscriber::firstOrCreate(['email' => $request->email]);

        // 3. Redirect Balik dengan Pesan Sukses
        return back()->with('success', 'Email lo udah masuk list VIP!');
    }
}