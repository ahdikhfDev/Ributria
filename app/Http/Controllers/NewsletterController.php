<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber; // Pastikan ini yang dipakai

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        Subscriber::firstOrCreate(['email' => $request->email]);

        return back()->with('success', 'Email lo udah masuk list VIP!');
    }
}