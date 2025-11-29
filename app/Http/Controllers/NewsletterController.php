<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;

class NewsletterController extends Controller
{
   public function subscribe(Request $request)
{
    $request->validate(['email' => 'required|email']);
    Subscriber::firstOrCreate(['email' => $request->email]);

    // Beda di sini: Balik ke halaman sebelumnya + bawa pesan sukses
    return back()->with('success', 'Email lo udah masuk list VIP!');
}
}