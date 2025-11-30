<section id="check-status" class="py-20 relative bg-black overflow-hidden border-t border-white/10">
    <!-- Hiasan Background -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary/10 rounded-full blur-[120px] pointer-events-none mix-blend-screen"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-secondary/10 rounded-full blur-[120px] pointer-events-none mix-blend-screen"></div>

    <div class="container mx-auto px-6 relative z-10">
        
        <!-- HEADER & SEARCH BOX (Desain Simpel Pilihan Lo) -->
        <div class="max-w-2xl mx-auto text-center">
            <h2 class="text-4xl font-black uppercase mb-2" :style="`color: ${activeTheme.text}`">
                CEK <span :style="`color: ${activeTheme.primary}`">STATUS LO</span>
            </h2>
            <p class="text-gray-500 font-mono mb-8">
                Udah transfer? Masukin kode booking lo di sini buat cek status tiket.
            </p>
            
            <div class="relative group">
                <!-- Glow Effect -->
                <div class="absolute -inset-1 bg-gradient-to-r from-transparent via-white/20 to-transparent blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                
                <!-- Input & Button -->
                <div class="relative flex gap-2">
                    <input type="text" 
                           x-model="checkCode" 
                           @keydown.enter="checkTransaction"
                           placeholder="KODE BOOKING / EMAIL LO" 
                           class="w-full bg-[#111] border border-white/20 p-4 text-white font-mono text-center uppercase tracking-widest focus:outline-none focus:border-opacity-100 transition-colors placeholder-gray-700" 
                           :style="`border-color: ${activeTheme.primary}`" />
                    
                    <button @click="checkTransaction" 
                            class="px-8 font-bold text-black uppercase transition-transform active:scale-95"
                            :style="`background-color: ${activeTheme.primary}`">
                        CEK
                    </button>
                </div>
            </div>
        </div>

        <!-- RESULT CONTAINER (Desain Tiket Premium) -->
        <div x-show="checkResult" 
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 translate-y-10 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             class="mt-16 max-w-4xl mx-auto text-left"
             style="display: none;">

            <!-- 1. TIKET SUKSES (PAID) - TAMPILAN TIKET FISIK -->
            <template x-if="checkResult && checkResult.status === 'success' && checkResult.data.status === 'paid'">
                <div class="relative w-full bg-[#111] border rounded-3xl overflow-hidden shadow-[0_0_50px_rgba(0,0,0,0.5)] transform hover:rotate-1 transition-transform duration-500"
                     :style="`border-color: ${activeTheme.primary}`">
                    
                    <!-- Background Noise -->
                    <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/stardust.png');"></div>
                    
                    <div class="flex flex-col md:flex-row">
                        <!-- Left Part (Main Ticket) -->
                        <div class="flex-1 p-8 md:p-10 relative border-b md:border-b-0 md:border-r border-dashed border-white/20">
                            <!-- Watermark -->
                            <div class="absolute right-0 top-1/2 -translate-y-1/2 text-[6rem] md:text-[10rem] font-black text-white/5 pointer-events-none select-none rotate-12 truncate max-w-full">PAID</div>

                            <div class="relative z-10">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-3 h-3 rounded-full animate-pulse" :style="`background-color: ${activeTheme.primary}`"></div>
                                    <span class="text-xs font-bold tracking-[0.3em] text-gray-400">ACCESS GRANTED</span>
                                </div>
                                <h3 class="text-3xl md:text-5xl font-black text-white uppercase leading-none italic mb-8" x-text="checkResult.data.ticket_name"></h3>

                                <div class="grid grid-cols-2 gap-8">
                                    <div>
                                        <div class="text-[10px] text-gray-500 uppercase tracking-wider mb-1">PEMILIK</div>
                                        <div class="text-lg md:text-xl font-bold text-white font-mono truncate" x-text="checkResult.data.guest_name"></div>
                                    </div>
                                    <div>
                                        <div class="text-[10px] text-gray-500 uppercase tracking-wider mb-1">REF BOOKING</div>
                                        <div class="text-lg md:text-xl font-bold text-white font-mono" x-text="checkCode.toUpperCase()"></div>
                                    </div>
                                </div>

                                <div class="mt-8 pt-8 border-t border-dashed border-white/20">
                                    <div class="text-[10px] text-gray-500 uppercase tracking-widest mb-2">KODE TIKET UNIK</div>
                                    <div class="text-4xl md:text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-500 font-mono tracking-tighter select-all cursor-pointer hover:opacity-80 transition-opacity"
                                         x-text="checkResult.data.ticket_code"></div>
                                </div>
                            </div>
                            
                            <!-- Cutout Circles -->
                            <div class="absolute -right-3 top-1/2 -mt-3 w-6 h-6 rounded-full bg-black z-20 hidden md:block"></div>
                        </div>

                        <!-- Right Part (Stub / QR) -->
                        <div class="md:w-72 bg-[#0a0a0a] p-8 flex flex-col items-center justify-center relative">
                            <div class="absolute -left-3 top-1/2 -mt-3 w-6 h-6 rounded-full bg-black z-20 hidden md:block"></div>
                            
                            <div class="w-40 h-40 bg-white p-2 rounded mb-4 shadow-lg transform hover:scale-105 transition-transform">
                                <!-- REAL QR CODE GENERATOR (API) -->
                                <img :src="`https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${checkResult.data.ticket_code}`" 
                                     alt="QR Code Tiket" 
                                     class="w-full h-full object-contain"
                                     title="Scan untuk Masuk">
                            </div>
                            <div class="text-center">
                                <div class="px-4 py-1 rounded-full text-[10px] font-bold uppercase mb-2 bg-green-500/20 text-green-500 border border-green-500/50 inline-block">
                                    VERIFIED
                                </div>
                                <div class="text-[10px] text-gray-600 font-mono">SCAN THIS AT GATE</div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <!-- 2. STATUS LAIN (PENDING/REJECTED) - Premium Card Design -->
            <template x-if="checkResult && checkResult.status === 'success' && checkResult.data.status !== 'paid'">
                <div class="bg-[#111] border border-white/10 rounded-xl p-12 text-center max-w-xl mx-auto relative overflow-hidden group shadow-2xl">
                    <div class="absolute top-0 left-0 w-full h-1 transition-colors duration-300" 
                         :class="{
                            'bg-yellow-500': checkResult.data.status === 'pending',
                            'bg-blue-500': checkResult.data.status === 'waiting_approval',
                            'bg-red-500': checkResult.data.status === 'rejected'
                         }"></div>
                    
                    <div class="mb-8 transform group-hover:scale-110 transition-transform duration-300">
                        <template x-if="checkResult.data.status === 'pending'">
                            <i data-lucide="clock" class="w-20 h-20 text-yellow-500 mx-auto animate-pulse"></i>
                        </template>
                        <template x-if="checkResult.data.status === 'waiting_approval'">
                            <i data-lucide="hourglass" class="w-20 h-20 text-blue-500 mx-auto animate-spin-slow"></i>
                        </template>
                        <template x-if="checkResult.data.status === 'rejected'">
                            <i data-lucide="x-circle" class="w-20 h-20 text-red-500 mx-auto"></i>
                        </template>
                    </div>

                    <h3 class="text-3xl font-black text-white uppercase mb-4 tracking-wide" x-text="checkResult.data.status_label"></h3>
                    <p class="text-gray-400 font-mono text-base mb-8">
                        Halo <span class="text-white font-bold" x-text="checkResult.data.guest_name"></span>, tiket <span class="text-white font-bold" x-text="checkResult.data.ticket_name"></span> lo belum aktif nih.
                    </p>

                    <template x-if="checkResult.data.status === 'pending'">
                        <a :href="'/payment/' + (checkCode.includes('TRX') ? checkCode : 'TRX-' + checkCode)" class="inline-flex items-center gap-3 px-8 py-4 bg-yellow-500 text-black font-black uppercase rounded hover:bg-yellow-400 transition-colors text-lg shadow-[0_0_20px_rgba(234,179,8,0.4)] hover:shadow-[0_0_30px_rgba(234,179,8,0.6)]">
                            BAYAR SEKARANG <i data-lucide="arrow-right" class="w-6 h-6"></i>
                        </a>
                    </template>
                </div>
            </template>

            <!-- 3. ERROR (NOT FOUND) -->
            <template x-if="checkResult && checkResult.status === 'error'">
                <div class="max-w-md mx-auto text-center p-8 border border-red-500/30 bg-red-500/5 rounded-2xl backdrop-blur-sm shadow-[0_0_30px_rgba(239,68,68,0.2)]">
                    <i data-lucide="shield-alert" class="w-16 h-16 text-red-500 mx-auto mb-6 animate-bounce"></i>
                    <h3 class="text-2xl font-bold text-white mb-2 tracking-wider">DATA TIDAK DITEMUKAN</h3>
                    <p class="text-red-400 font-mono text-sm mb-0" x-text="checkResult.message || 'Cek lagi kode atau email lo, bro.'"></p>
                    <div class="text-[10px] text-gray-600 uppercase tracking-widest mt-4 pt-4 border-t border-red-500/20">ERROR 404 // SYSTEM FAILURE</div>
                </div>
            </template>
        </div>
    </div>
</section>