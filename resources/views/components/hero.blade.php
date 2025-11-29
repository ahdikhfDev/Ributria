<section class="relative z-10 w-full h-screen flex flex-col md:flex-row items-center justify-center px-6 md:px-0">
    
    <!-- Left: Typography -->
    <div class="md:w-1/2 h-full flex flex-col justify-center relative z-20 md:pl-20 pt-20 md:pt-0">
        <div class="relative" :style="`transform: translate(${mousePos.x * -10}px, ${mousePos.y * -10}px)`">
            
            <!-- Countdown (Logic di JS) -->
            <div class="flex gap-4 mb-8 font-mono animate-fade-in-up" :style="`color: ${activeTheme.primary}`">
                <template x-for="(value, unit) in timeLeft">
                    <div class="text-center">
                        <div class="text-3xl font-black bg-white/5 border border-white/10 px-3 py-2 rounded mb-1 min-w-[60px]" x-text="value.toString().padStart(2, '0')"></div>
                        <div class="text-[10px] uppercase tracking-wider opacity-60" x-text="unit"></div>
                    </div>
                </template>
            </div>

            <!-- Badge Tahun Dinamis -->
            <div class="inline-flex items-center gap-2 px-3 py-1 border bg-white/5 rounded-full text-xs font-bold tracking-widest mb-6 backdrop-blur-sm"
                 :style="`border-color: ${activeTheme.primary}4D; color: ${activeTheme.primary}`">
                <span class="w-2 h-2 rounded-full animate-pulse" :style="`background-color: ${activeTheme.primary}`"></span>
                KONSER LIVE {{ \Carbon\Carbon::parse($settings->event_date)->year ?? '2025' }}
            </div>

            <!-- JUDUL UTAMA DARI DATABASE -->
            <h2 class="text-6xl md:text-[7vw] font-black leading-[0.9] tracking-tighter mix-blend-difference">
                {!! nl2br(e($settings->hero_title)) !!}
            </h2>
            
            <!-- DESKRIPSI DARI DATABASE -->
            <p class="mt-8 max-w-md text-gray-400 text-sm md:text-base leading-relaxed border-l-2 pl-6" :style="`border-color: ${activeTheme.primary}`">
                {{ $settings->hero_description }}
            </p>

            <div class="mt-10 flex flex-wrap gap-4">
                <button @click="document.getElementById('tickets').scrollIntoView({behavior: 'smooth'})" class="group relative px-8 py-4 bg-[#e0e0e0] text-black font-bold text-lg overflow-hidden transition-transform active:scale-95">
                    <div class="absolute inset-0 w-full h-full translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out" :style="`background-color: ${activeTheme.primary}`"></div>
                    <span class="relative z-10 group-hover:text-black flex items-center gap-2">
                        BELI TIKET <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
                    </span>
                </button>
                
                <button class="px-8 py-4 border border-white/20 hover:bg-white/5 font-bold text-lg transition-colors flex items-center gap-3 backdrop-blur-sm" :style="`color: ${activeTheme.text}`">
                    <i data-lucide="play" class="w-4 h-4 fill-current"></i> DAFTAR ARTIS
                </button>
            </div>
        </div>
    </div>

    <!-- Right: Ticket Visual (Animasi 3D) -->
    <div class="md:w-1/2 h-full relative flex items-center justify-center pointer-events-none md:pointer-events-auto">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] rounded-full blur-[120px] opacity-20 animate-pulse-slow" :style="`background-color: ${activeTheme.primary}`"></div>

        <div class="relative z-30 transition-transform duration-100 ease-out"
             :style="`transform: perspective(1000px) rotateX(${mousePos.y * 5}deg) rotateY(${mousePos.x * -5}deg) translate(${mousePos.x * 20}px, ${mousePos.y * 20}px)`">
            
            <!-- Visual Tiket -->
            <div class="relative flex w-[600px] h-[250px] shadow-2xl rounded-lg overflow-hidden group">
                <!-- Bagian Kiri Tiket -->
                <div class="flex-[2] bg-gradient-to-br relative p-8 flex flex-col justify-between"
                     :style="`background-image: linear-gradient(to bottom right, ${activeTheme.cardBg}, #000)`">
                    <div class="absolute inset-0 opacity-20" style="background-image: url('https://www.transparenttextures.com/patterns/stardust.png');"></div>
                    <div class="flex justify-between items-start relative z-10 text-white">
                        <div class="border border-white/30 px-3 py-1 text-xs font-bold uppercase tracking-widest">PUSAT SENI</div>
                        <div class="text-right">
                            <!-- Tanggal Dinamis -->
                            <div class="text-2xl font-black leading-none">{{ \Carbon\Carbon::parse($settings->event_date)->day ?? '25' }}</div>
                            <div class="text-[10px] uppercase font-bold tracking-wider">{{ \Carbon\Carbon::parse($settings->event_date)->format('F') ?? 'AGUSTUS' }}</div>
                        </div>
                    </div>
                    <div class="relative z-10 text-center">
                        <!-- Judul Web di Tiket (Disingkat) -->
                        <h2 class="text-5xl font-black uppercase tracking-tighter text-white mb-2 drop-shadow-lg">
                            {{ Str::limit($settings->hero_title, 15) }}
                        </h2>
                        <div class="text-sm font-bold tracking-[0.5em] uppercase" :style="`color: ${activeTheme.secondary}`">TAMPIL LIVE</div>
                    </div>
                    <div class="relative z-10 flex justify-between items-end">
                        <div class="border-2 rounded px-4 py-2 transform -rotate-3 bg-black/20 backdrop-blur-sm" :style="`border-color: ${activeTheme.primary}`">
                            <div class="text-[8px] uppercase font-bold" :style="`color: ${activeTheme.primary}`">HARGA</div>
                            <div class="text-xl font-bold text-white">Rp 750K++</div>
                        </div>
                        <div class="h-8 w-24 flex items-end justify-between gap-[2px]">
                            <template x-for="i in 25"><div class="bg-white" :style="`width: ${Math.random() * 4}px; height: ${(Math.random() * 50 + 50)}%`"></div></template>
                        </div>
                    </div>
                </div>
                
                <!-- Garis Sobek Tiket -->
                <div class="relative w-0 border-r-2 border-dashed border-white/30" :style="`background-color: ${activeTheme.cardBg}`">
                    <div class="absolute -top-3 -left-3 w-6 h-6 rounded-full z-20" :style="`background-color: ${activeTheme.bg}`"></div>
                    <div class="absolute -bottom-3 -left-3 w-6 h-6 rounded-full z-20" :style="`background-color: ${activeTheme.bg}`"></div>
                </div>

                <!-- Bagian Kanan Tiket -->
                <div class="flex-1 bg-gradient-to-bl relative p-4 flex flex-col items-center justify-center"
                     :style="`background-image: linear-gradient(to bottom left, ${activeTheme.primary}40, ${activeTheme.cardBg})`">
                    <div class="absolute inset-0 opacity-20" style="background-image: url('https://www.transparenttextures.com/patterns/stardust.png');"></div>
                    <div class="relative z-10 h-full flex items-center justify-between w-full text-white">
                        <h3 class="text-3xl font-black uppercase tracking-widest" style="writing-mode: vertical-rl; text-orientation: mixed;">
                            {{ Str::limit($settings->hero_title, 10, '') }}
                        </h3>
                        <div class="text-[8px] font-mono opacity-50" style="writing-mode: vertical-rl;">KONSER MUSIK</div>
                    </div>
                    <div class="absolute bottom-4 right-4 rotate-[-90deg] text-[10px] font-mono tracking-widest opacity-60 text-white">NO. 839201</div>
                </div>
            </div>

            <!-- Sticker -->
            <div class="absolute -top-6 -right-6 w-24 h-24 text-black rounded-full flex items-center justify-center font-black -rotate-12 shadow-lg animate-[bounce_3s_infinite] z-20"
                 :style="`background-color: ${activeTheme.secondary}`">
                <span class="text-center text-xs leading-tight">SOLD<br/>OUT<br/>BENTAR</span>
            </div>
        </div>
    </div>
</section>