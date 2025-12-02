@extends('layouts.app')

@section('content')
    <!-- Container Utama -->
    <div class="min-h-screen flex items-center justify-center p-6 relative z-10 pt-24">
        
        <!-- Dynamic Background Glows -->
        <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-[150px] pointer-events-none opacity-20" :style="`background-color: ${activeTheme.primary}`"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 rounded-full blur-[150px] pointer-events-none opacity-20" :style="`background-color: ${activeTheme.secondary}`"></div>

        <!-- Card Invoice -->
        <div class="max-w-3xl w-full bg-[#111] border-2 rounded-3xl overflow-hidden shadow-[0_0_50px_rgba(0,0,0,0.5)] relative animate-fade-in-up"
             :style="`border-color: ${activeTheme.primary}`">
             
            <!-- Background Noise -->
            <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/stardust.png');"></div>

            <!-- Header Strip -->
            <div class="h-2 w-full" :style="`background: linear-gradient(to right, ${activeTheme.primary}, ${activeTheme.secondary})`"></div>

            <div class="p-8 md:p-12 relative z-10">
                <!-- Header & Status -->
                <div class="text-center mb-10">
                    <h1 class="text-4xl md:text-5xl font-black uppercase tracking-tighter mb-4 text-white">
                        INVOICE <span class="text-transparent bg-clip-text" :style="`background-image: linear-gradient(to right, ${activeTheme.primary}, ${activeTheme.secondary}); -webkit-text-stroke: 0;`">PEMBAYARAN</span>
                    </h1>
                    
                    <!-- STATUS BADGE -->
                    @php
                        $statusText = match($transaction->status) {
                            'pending' => 'MENUNGGU PEMBAYARAN',
                            'waiting_approval' => 'MENUNGGU VERIFIKASI',
                            'paid' => 'LUNAS (TIKET RESMI)',
                            'rejected' => 'DITOLAK (CEK BUKTI)',
                            default => 'UNKNOWN'
                        };
                        
                    @endphp

                    <div class="inline-block px-6 py-2 border-2 rounded-lg font-mono text-sm md:text-base font-bold uppercase tracking-widest animate-pulse"
                         :style="`
                            border-color: {{ $transaction->status == 'paid' ? '#22c55e' : ($transaction->status == 'rejected' ? '#ef4444' : ($transaction->status == 'pending' ? '#eab308' : '#3b82f6')) }};
                            color: {{ $transaction->status == 'paid' ? '#22c55e' : ($transaction->status == 'rejected' ? '#ef4444' : ($transaction->status == 'pending' ? '#eab308' : '#3b82f6')) }};
                            background-color: {{ $transaction->status == 'paid' ? '#22c55e10' : ($transaction->status == 'rejected' ? '#ef444410' : ($transaction->status == 'pending' ? '#eab30810' : '#3b82f610')) }};
                         `">
                        STATUS: {{ $statusText }}
                    </div>
                </div>

                <!-- 🔥 TIKET RESMI (JIKA LUNAS) - TAMPILAN PREMIUM 🔥 -->
                @if($transaction->status == 'paid')
                    <div class="mb-12 relative group cursor-default">
                        <div class="absolute -inset-1 bg-gradient-to-r from-green-500 via-emerald-500 to-green-500 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
                        <div class="bg-[#0a0a0a] border-2 border-green-500 border-dashed rounded-xl p-8 relative overflow-hidden">
                            <!-- Watermark -->
                            <div class="absolute right-[-20px] top-1/2 -translate-y-1/2 text-[6rem] font-black text-green-900/20 pointer-events-none select-none rotate-12">PAID</div>
                            
                            <div class="flex flex-col md:flex-row items-center justify-between gap-6 relative z-10">
                                <div class="text-center md:text-left">
                                    <div class="text-xs text-green-500 font-bold uppercase tracking-[0.3em] mb-2">KODE TIKET RESMI</div>
                                    <div class="text-4xl md:text-6xl font-black text-white font-mono tracking-widest select-all" style="text-shadow: 0 0 20px rgba(34, 197, 94, 0.5);">
                                        {{ $transaction->ticket_code }}
                                    </div>
                                    <p class="text-gray-400 text-xs mt-2 font-mono">
                                        Screenshot halaman ini atau simpan kodenya. Tunjukkan di pintu masuk.
                                    </p>
                                </div>
                                
                                <!-- QR Code -->
                                <div class="bg-white p-2 rounded-lg shadow-[0_0_20px_rgba(34,197,94,0.3)]">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $transaction->ticket_code }}" 
                                         alt="QR Ticket" class="w-32 h-32 object-contain">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- DETAIL ORDER GRID -->
                <div class="grid md:grid-cols-2 gap-8 mb-10">
                    <!-- Kiri: Data Pesanan -->
                    <div>
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4 pb-2 border-b border-white/10">DATA PEMESAN</h3>
                        <div class="space-y-4 font-mono text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Ref Booking</span>
                                <span class="text-white font-bold bg-white/10 px-2 py-1 rounded select-all">{{ $transaction->code }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Nama</span>
                                <span class="text-white uppercase">{{ $transaction->guest_name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Email</span>
                                <span class="text-white">{{ $transaction->guest_email }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Tiket</span>
                                <span class="text-white font-bold" :style="`color: ${activeTheme.secondary}`">
                                    {{ $transaction->ticket->name }} <span class="text-gray-500">(x{{ $transaction->quantity }})</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Kanan: Total Bayar -->
                    <div class="flex flex-col justify-center text-center bg-white/5 border border-white/10 p-6 rounded-xl relative overflow-hidden">
                        <!-- Glow Corner -->
                        <div class="absolute top-0 right-0 w-16 h-16 bg-white/5 rounded-bl-full"></div>
                        
                        <span class="text-xs text-gray-500 uppercase tracking-widest mb-2">TOTAL TRANSFER</span>
                        <span class="text-4xl font-black tracking-tighter" :style="`color: ${activeTheme.primary}`">
                            Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                        </span>
                        
                        @if($transaction->status == 'pending')
                            <div class="mt-2 text-[10px] text-red-400 font-mono bg-red-500/10 border border-red-500/20 py-1 px-2 rounded inline-block mx-auto animate-pulse">
                                ⚠️ JANGAN BULATKAN NOMOR UNIK
                            </div>
                        @endif
                    </div>
                </div>

                <!-- FORM UPLOAD / INFO BANK  -->
                @if($transaction->status == 'pending' || $transaction->status == 'rejected')
                    <div class="bg-[#0a0a0a] p-6 md:p-8 rounded-2xl border border-white/10 mb-8 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-1 h-full" :style="`background-color: ${activeTheme.primary}`"></div>
                        
                        <h3 class="text-lg font-black text-white uppercase mb-6 flex items-center gap-2">
                            <i data-lucide="credit-card" class="w-5 h-5" :style="`color: ${activeTheme.primary}`"></i> 
                            METODE PEMBAYARAN
                        </h3>
                        
                        <div class="flex flex-col md:flex-row items-center gap-8 mb-8">
                            @if($settings->qris_image)
                                <div class="w-40 h-40 bg-white p-2 rounded-lg shadow-lg flex-shrink-0 transform hover:scale-105 transition-transform">
                                    <img src="{{ Storage::url($settings->qris_image) }}" alt="QRIS" class="w-full h-full object-contain">
                                </div>
                            @endif
                            
                            <div class="flex-1 w-full text-center md:text-left">
                                <div class="text-xl font-bold text-white mb-1">{{ $settings->bank_name ?? 'BANK TRANSFER' }}</div>
                                <div class="font-mono text-3xl md:text-4xl tracking-widest my-2 select-all cursor-pointer bg-white/5 p-4 rounded border border-dashed border-white/20 hover:border-white hover:bg-white/10 transition-all" 
                                     title="Klik untuk copy"
                                     :style="`color: ${activeTheme.secondary}`">
                                    {{ $settings->bank_account_number ?? 'BELUM DISET' }}
                                </div>
                                <div class="text-sm text-gray-400">A/N <span class="text-white font-bold">{{ $settings->bank_account_name }}</span></div>
                            </div>
                        </div>

                        <!-- Upload Form -->
                        <form action="{{ route('payment.upload', $transaction->code) }}" method="POST" enctype="multipart/form-data" class="border-t border-white/10 pt-6">
                            @csrf
                            <div class="mb-6">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-3">SUDAH TRANSFER? UPLOAD BUKTI DI SINI</label>
                                <div class="relative group">
                                    <input type="file" name="payment_proof" required class="block w-full text-sm text-gray-400
                                        file:mr-4 file:py-3 file:px-6
                                        file:rounded-lg file:border-0
                                        file:text-sm file:font-black file:uppercase
                                        file:bg-white file:text-black
                                        file:cursor-pointer hover:file:bg-gray-200 
                                        cursor-pointer bg-[#111] border border-gray-700 rounded-xl p-2 focus:outline-none focus:border-white transition-colors
                                    "/>
                                </div>
                            </div>

                            <button type="submit" 
                                    class="w-full py-4 text-black font-black uppercase text-lg rounded-xl transition-all transform hover:scale-[1.01] active:scale-[0.99] shadow-lg relative overflow-hidden group"
                                    :style="`background-color: ${activeTheme.primary}`">
                                <span class="relative z-10 flex items-center justify-center gap-2">
                                    KIRIM BUKTI PEMBAYARAN <i data-lucide="upload-cloud" class="w-5 h-5"></i>
                                </span>
                                <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                            </button>
                        </form>
                    </div>
                
                @elseif($transaction->status == 'waiting_approval')
                    <div class="bg-blue-500/10 border border-blue-500/30 p-8 rounded-2xl text-center mb-8 backdrop-blur-sm">
                        <div class="inline-block p-4 bg-blue-500/20 rounded-full mb-4 animate-pulse">
                            <i data-lucide="hourglass" class="w-10 h-10 text-blue-500"></i>
                        </div>
                        <h3 class="text-xl font-black text-white uppercase tracking-wider">BUKTI DITERIMA</h3>
                        <p class="text-blue-200 font-mono text-sm mt-2 max-w-md mx-auto">
                            Admin lagi ngecek mutasi bank lo. Santai dulu, tiket bakal muncul di sini otomatis kalau udah diapprove.
                        </p>
                    </div>
                @endif
                
                <!-- Flash Message -->
                @if(session('success'))
                    <div class="mt-6 p-4 bg-green-500/20 text-green-400 text-center font-bold border border-green-500/50 rounded-xl font-mono text-sm flex items-center justify-center gap-2">
                        <i data-lucide="check-circle" class="w-5 h-5"></i> {{ session('success') }}
                    </div>
                @endif
            </div>
            
            <!-- Footer Actions -->
            <div class="bg-[#0a0a0a] p-6 border-t border-gray-800 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="text-xs text-gray-500 font-mono flex items-center gap-2">
                    <i data-lucide="hash" class="w-3 h-3"></i> Ref: <span class="text-white font-bold select-all">{{ $transaction->code }}</span>
                </div>
                
                <a href="{{ route('home') }}" class="px-6 py-3 bg-white/5 hover:bg-white/10 border border-white/10 text-white font-bold uppercase text-xs rounded-lg transition-colors flex items-center gap-2 group">
                    <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i> KEMBALI KE BERANDA
                </a>
            </div>
        </div>
    </div>
@endsection