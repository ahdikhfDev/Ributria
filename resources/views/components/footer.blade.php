<div class="relative pt-32 pb-0 overflow-hidden flex flex-col items-center justify-center bg-black border-t border-white/10">
    <!-- Texture Overlay -->
    <div class="absolute inset-0 opacity-30 pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');"></div>
    
    <!-- Stacked Text Effect (Judul Besar di Belakang) -->
    <div class="relative z-10 mb-12">
        <h2 class="text-[18vw] font-black leading-[0.8] tracking-tighter text-transparent text-stroke-white opacity-20 absolute top-0 left-0 transform -translate-x-4 -translate-y-4 select-none pointer-events-none">RiButRiA</h2>
        <h2 class="text-[18vw] font-black leading-[0.8] tracking-tighter text-transparent text-stroke-primary opacity-40 absolute top-0 left-0 transform translate-x-2 translate-y-2 select-none pointer-events-none" :style="`-webkit-text-stroke-color: ${activeTheme.primary}`">RiButRiA</h2>
        <h2 class="text-[18vw] font-black leading-[0.8] tracking-tighter relative z-20 hover:text-transparent hover:text-stroke-white transition-all duration-500 cursor-default" :style="`color: ${activeTheme.text}`">RiButRiA</h2>
    </div>
    
    <div class="mb-16 font-mono text-sm tracking-[1em] uppercase opacity-50" :style="`color: ${activeTheme.primary}`">Sistem Tiket v.2.0.5</div>

    <!-- MAIN FOOTER GRID -->
    <footer class="w-full bg-black border-t border-white/10 text-white font-mono text-sm relative z-20">
        <div class="grid grid-cols-1 md:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-white/10 border-b border-white/10">
            
            <!-- KOLOM 1: LOKASI (DINAMIS) -->
            <div class="p-8 hover:bg-white/5 transition-colors group h-full">
                <div class="text-[10px] text-gray-500 mb-4 uppercase tracking-widest">01 // KOORDINAT</div>
                <div class="text-2xl font-bold mb-2 group-hover:text-primary transition-colors" :style="`color: ${activeTheme.text}`">LOKASI EVENT</div>
                
                <!-- Ambil Nama Lokasi dari Database -->
                <div class="text-gray-400 text-lg">{{ $settings->location_name }}</div>
                
                <!-- Koordinat (Hardcoded sementara, atau bisa tambah field di DB nanti) -->
                <div class="mt-1 font-mono tracking-wider" :style="`color: ${activeTheme.primary}`">
                    -6.2088° S, 106.8456° E
                </div>
            </div>

            <!-- KOLOM 2: SOSMED -->
            <div class="p-8 hover:bg-white/5 transition-colors h-full">
                <div class="text-[10px] text-gray-500 mb-4 uppercase tracking-widest">02 // JARINGAN</div>
                <div class="flex flex-col gap-4 text-gray-500">
                    <a href="#" class="hover:text-white transition-colors flex items-center gap-2 group"><span class="w-0 group-hover:w-4 transition-all duration-300 h-[1px] bg-current"></span>INSTAGRAM</a>
                    <a href="#" class="hover:text-white transition-colors flex items-center gap-2 group"><span class="w-0 group-hover:w-4 transition-all duration-300 h-[1px] bg-current"></span>TWITTER / X</a>
                    <a href="#" class="hover:text-white transition-colors flex items-center gap-2 group"><span class="w-0 group-hover:w-4 transition-all duration-300 h-[1px] bg-current"></span>TIKTOK</a>
                </div>
            </div>

            <!-- KOLOM 3: LEGAL -->
            <div class="p-8 hover:bg-white/5 transition-colors h-full">
                <div class="text-[10px] text-gray-500 mb-4 uppercase tracking-widest">03 // PROTOKOL</div>
                <div class="flex flex-col gap-4 text-gray-500">
                    <a href="#" class="hover:text-white">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-white">Kebijakan Refund</a>
                </div>
            </div>

            <!-- KOLOM 4: SCROLL TOP -->
            <div class="p-8 flex flex-col justify-between hover:bg-white/5 transition-colors cursor-pointer group h-full" @click="window.scrollTo({ top: 0, behavior: 'smooth' })">
                <div class="text-right">
                    <div class="inline-block p-4 border border-white/20 rounded-full group-hover:bg-white group-hover:text-black transition-all mb-4">
                        <i data-lucide="arrow-up" class="w-6 h-6"></i>
                    </div>
                    <div class="font-bold text-lg tracking-wider">BALIK KE ATAS</div>
                </div>
                <!-- Tahun Otomatis -->
                <div class="text-right text-[10px] text-gray-600 mt-12 group-hover:text-gray-400 transition-colors">
                    SISTEM ONLINE <br/> HAK CIPTA DILINDUNGI {{ date('Y') }}
                </div>
            </div>
        </div>
        
        <!-- Bottom Bar -->
        <div class="py-2 bg-white/5 text-center text-[10px] text-gray-500 uppercase tracking-widest border-t border-white/5">
            Dibuat buat Rusuh • Dibangun buat Bising • Amanin Tempat Lo
        </div>
    </footer>
</div>