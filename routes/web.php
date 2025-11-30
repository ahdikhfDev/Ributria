<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OracleController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/chat', [OracleController::class, 'chat'])->name('chat.send');

Route::post('/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// --- TICKET ROUTES ---
Route::post('/ticket/checkout', [TicketController::class, 'checkout'])->name('ticket.checkout');
Route::get('/payment/{code}', [TicketController::class, 'showPayment'])->name('payment.show');
Route::post('/payment/{code}/upload', [TicketController::class, 'uploadProof'])->name('payment.upload');

Route::post('/ticket/check-status', [TicketController::class, 'checkStatus'])->name('ticket.checkStatus');