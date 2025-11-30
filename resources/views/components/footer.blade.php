<div class="relative pt-32 pb-0 overflow-hidden flex flex-col items-center justify-center bg-black border-t border-white/10">
    <!-- Texture Overlay -->
    <div class="absolute inset-0 opacity-20 pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');"></div>
    
    <!-- Stacked Text Effect (Judul Besar di Belakang) -->
    <div class="relative z-10 mb-12 select-none pointer-events-none">
        <h2 class="text-[18vw] font-black leading-[0.8] tracking-tighter text-transparent text-stroke-white opacity-10 absolute top-0 left-0 transform -translate-x-4 -translate-y-4">RiButRiA</h2>
        <h2 class="text-[18vw] font-black leading-[0.8] tracking-tighter text-transparent text-stroke-primary opacity-30 absolute top-0 left-0 transform translate-x-2 translate-y-2 mix-blend-screen" :style="`-webkit-text-stroke-color: ${activeTheme.primary}`">RiButRiA</h2>
        <h2 class="text-[18vw] font-black leading-[0.8] tracking-tighter relative z-20 text-transparent text-stroke-white transition-all duration-500 hover:text-white cursor-default" :style="`color: ${activeTheme.text}`">RiButRiA</h2>
    </div>
    
    <div class="mb-16 font-mono text-xs md:text-sm tracking-[1em] uppercase opacity-50" :style="`color: ${activeTheme.primary}`">Sistem Tiket v.2.0.5 // ONLINE</div>

    <!-- MAIN FOOTER GRID -->
    <footer class="w-full bg-[#050505] border-t border-white/10 text-white font-mono text-sm relative z-20">
        <div class="grid grid-cols-1 md:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-white/10 border-b border-white/10">
            
            <!-- KOLOM 1: LOKASI (DINAMIS) -->
            <div class="p-8 md:p-10 hover:bg-white/5 transition-colors group h-full flex flex-col justify-between">
                <div>
                    <div class="text-[10px] text-gray-500 mb-4 uppercase tracking-widest border-b border-white/10 pb-2 w-max">01 // KOORDINAT</div>
                    <div class="text-3xl font-black mb-2 group-hover:text-primary transition-colors uppercase leading-none" :style="`color: ${activeTheme.text}`">LOKASI EVENT</div>
                    
                    <!-- Ambil Nama Lokasi dari Database -->
                    <div class="text-gray-400 text-lg mt-4">{{ $settings->location_name }}</div>
                    
                    <!-- KOORDINAT DINAMIS DARI DB -->
                    <div class="mt-1 font-mono tracking-wider text-xs opacity-70 group-hover:opacity-100 transition-opacity" :style="`color: ${activeTheme.primary}`">
                        {{ $settings->footer_coordinates ?? '-6.2088° S, 106.8456° E' }}
                    </div>
                </div>
                
                <a href="https://maps.google.com/?q={{ $settings->location_name }}" target="_blank" class="mt-8 inline-flex items-center gap-2 text-xs font-bold uppercase border-b border-transparent hover:border-white transition-all w-max pb-1">
                    OPEN MAPS <i data-lucide="map-pin" class="w-3 h-3"></i>
                </a>
            </div>

            <!-- KOLOM 2: SOSMED -->
            <div class="p-8 md:p-10 hover:bg-white/5 transition-colors h-full">
                <div class="text-[10px] text-gray-500 mb-6 uppercase tracking-widest border-b border-white/10 pb-2 w-max">02 // JARINGAN</div>
                <div class="flex flex-col gap-6 text-gray-400">
                    <a href="#" class="flex items-center gap-3 group hover:text-white transition-colors">
                        <i data-lucide="instagram" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                        <span class="relative">
                            INSTAGRAM
                            <span class="absolute left-0 -bottom-1 w-0 h-[1px] bg-white transition-all duration-300 group-hover:w-full"></span>
                        </span>
                    </a>
                    <a href="#" class="flex items-center gap-3 group hover:text-white transition-colors">
                        <i data-lucide="twitter" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                        <span class="relative">
                            TWITTER / X
                            <span class="absolute left-0 -bottom-1 w-0 h-[1px] bg-white transition-all duration-300 group-hover:w-full"></span>
                        </span>
                    </a>
                    <a href="#" class="flex items-center gap-3 group hover:text-white transition-colors">
                        <i data-lucide="music" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                        <span class="relative">
                            TIKTOK
                            <span class="absolute left-0 -bottom-1 w-0 h-[1px] bg-white transition-all duration-300 group-hover:w-full"></span>
                        </span>
                    </a>
                </div>
            </div>

            <!-- KOLOM 3: LEGAL -->
            <div class="p-8 md:p-10 hover:bg-white/5 transition-colors h-full">
                <div class="text-[10px] text-gray-500 mb-6 uppercase tracking-widest border-b border-white/10 pb-2 w-max">03 // PROTOKOL</div>
                <div class="flex flex-col gap-4 text-gray-500 text-xs md:text-sm">
                    <a href="#" class="hover:text-white hover:translate-x-2 transition-all duration-300 flex items-center gap-2">
                        <i data-lucide="shield" class="w-3 h-3"></i> Kebijakan Privasi
                    </a>
                    <a href="#" class="hover:text-white hover:translate-x-2 transition-all duration-300 flex items-center gap-2">
                        <i data-lucide="file-text" class="w-3 h-3"></i> Syarat & Ketentuan
                    </a>
                    <a href="#" class="hover:text-white hover:translate-x-2 transition-all duration-300 flex items-center gap-2">
                        <i data-lucide="refresh-cw" class="w-3 h-3"></i> Kebijakan Refund
                    </a>
                </div>
            </div>

            <!-- KOLOM 4: SCROLL TOP -->
            <div class="p-8 md:p-10 flex flex-col justify-between hover:bg-white/5 transition-colors cursor-pointer group h-full bg-gradient-to-b from-transparent to-white/5" 
                 @click="window.scrollTo({ top: 0, behavior: 'smooth' })">
                
                <div class="text-right">
                    <div class="inline-block p-4 border border-white/20 rounded-full group-hover:bg-white group-hover:text-black transition-all duration-500 mb-4 transform group-hover:-translate-y-2 shadow-lg">
                        <i data-lucide="arrow-up" class="w-6 h-6 animate-bounce"></i>
                    </div>
                    <div class="font-black text-xl tracking-wider uppercase">BACK TO TOP</div>
                    <div class="text-[10px] text-gray-500 mt-1">SCROLL KE ATAS</div>
                </div>

                <!-- Tahun Otomatis -->
                <div class="text-right text-[10px] text-gray-600 mt-12 group-hover:text-gray-400 transition-colors">
                    <span class="block font-bold text-xs mb-1" :style="`color: ${activeTheme.primary}`">SECURE CONNECTION</span>
                    HAK CIPTA DILINDUNGI {{ date('Y') }}
                </div>
            </div>
        </div>
        
        <!-- Bottom Bar -->
        <div class="py-3 bg-black text-center text-[10px] text-gray-600 uppercase tracking-[0.2em] border-t border-white/5 hover:text-white transition-colors cursor-default">
            Dibuat buat Rusuh • Dibangun buat Bising • Amanin Tempat Lo
        </div>
    </footer>
</div>