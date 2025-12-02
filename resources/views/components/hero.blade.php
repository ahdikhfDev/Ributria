<section class="relative z-10 w-full min-h-screen flex flex-col md:flex-row items-center justify-center px-6 overflow-hidden">
    
    <!-- Left: Typography -->
    <div class="w-full md:w-1/2 h-full flex flex-col justify-center relative z-20 md:pl-20 pt-10 md:pt-0 order-2 md:order-1">
        <div class="relative transition-transform duration-100 ease-out" 
             :style="window.innerWidth > 768 ? `transform: translate(${mousePos.x * -10}px, ${mousePos.y * -10}px)` : ''">
            
            <!-- (Countdown DIPINDAHKAN DARI SINI KE KANAN) -->

            <div class="flex justify-center md:justify-start mb-6 md:mt-16">
                <div class="inline-flex items-center gap-2 px-3 py-1 border bg-white/5 rounded-full text-[10px] md:text-xs font-bold tracking-widest backdrop-blur-sm"
                     :style="`border-color: ${activeTheme.primary}4D; color: ${activeTheme.primary}`">
                    <span class="w-2 h-2 rounded-full animate-pulse" :style="`background-color: ${activeTheme.primary}`"></span>
                    KONSER LIVE {{ \Carbon\Carbon::parse($settings->event_date)->year ?? '2025' }}
                </div>
            </div>

            <!-- JUDUL UTAMA WEB -->
            <h2 class="text-5xl md:text-6xl lg:text-[6vw] font-black leading-[0.9] tracking-tighter mix-blend-difference text-center md:text-left">
                {!! nl2br(e($settings->hero_title)) !!}
            </h2>
            
            <!-- DESKRIPSI WEB -->
            <p class="mt-6 md:mt-8 max-w-md mx-auto md:mx-0 text-gray-400 text-sm md:text-base leading-relaxed border-l-0 md:border-l-2 pl-0 md:pl-6 text-center md:text-left" :style="`border-color: ${activeTheme.primary}`">
                {{ $settings->hero_description }}
            </p>

            <div class="mt-8 md:mt-10 mb-10 md:mb-0 flex flex-col sm:flex-row items-center justify-center md:justify-start gap-4">
                <button @click="document.getElementById('tickets').scrollIntoView({behavior: 'smooth'})" 
                        class="w-full sm:w-auto group relative px-8 py-4 bg-[#e0e0e0] text-black font-bold text-lg overflow-hidden transition-transform active:scale-95 rounded md:rounded-none">
                    <div class="absolute inset-0 w-full h-full translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out" :style="`background-color: ${activeTheme.primary}`"></div>
                    <span class="relative z-10 group-hover:text-black flex items-center justify-center gap-2">
                        BELI TIKET <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
                    </span>
                </button>
                
                <button @click="document.getElementById('artists').scrollIntoView({behavior: 'smooth'})"
                        class="w-full sm:w-auto px-8 py-4 border border-white/20 hover:bg-white/5 font-bold text-lg transition-colors flex items-center justify-center gap-3 backdrop-blur-sm rounded md:rounded-none" 
                        :style="`color: ${activeTheme.text}`">
                    <i data-lucide="play" class="w-4 h-4 fill-current"></i> DAFTAR ARTIS
                </button>
            </div>
        </div>
    </div>

    <!-- Right: Ticket Visual (Animasi 3D) -->
    <!-- Tambahkan 'flex-col' untuk menumpuk Countdown di atas Tiket -->
    <div class="w-full md:w-1/2 h-[400px] md:h-full relative flex flex-col items-center justify-center pointer-events-none md:pointer-events-auto order-1 md:order-2 mb-8 md:mb-0 mt-20 md:mt-0">
        
        <!-- Glow Background -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[250px] h-[250px] md:w-[400px] md:h-[400px] rounded-full blur-[80px] md:blur-[120px] opacity-20 animate-pulse-slow" :style="`background-color: ${activeTheme.primary}`"></div>

        <!-- COUNTDOWN (DIPINDAHKAN KE SINI) -->
        <div class="relative z-40 flex justify-center gap-2 md:gap-4 mb-8 font-mono animate-fade-in-up" :style="`color: ${activeTheme.primary}`">
            <template x-for="(value, unit) in timeLeft">
                <div class="text-center">
                    <!-- Tambah background gelap transparan biar kebaca jelas di atas glow -->
                    <div class="text-xl md:text-3xl font-black bg-black/50 border border-white/20 px-2 md:px-3 py-2 rounded mb-1 min-w-[45px] md:min-w-[60px] backdrop-blur-md shadow-lg" x-text="value.toString().padStart(2, '0')"></div>
                    <div class="text-[8px] md:text-[10px] uppercase tracking-wider opacity-80 font-bold bg-black/30 rounded px-1" x-text="unit"></div>
                </div>
            </template>
        </div>

        <!-- Ticket Wrapper -->
        <div class="relative z-30 w-full max-w-[90%] md:max-w-[600px] transition-transform duration-100 ease-out"
             :style="window.innerWidth > 768 ? `transform: perspective(1000px) rotateX(${mousePos.y * 5}deg) rotateY(${mousePos.x * -5}deg) translate(${mousePos.x * 20}px, ${mousePos.y * 20}px)` : ''">
            
            <!-- Visual Tiket -->
            <div class="relative flex w-full aspect-[2.4/1] md:h-[250px] shadow-2xl rounded-lg overflow-hidden group transform scale-95 md:scale-100">
                
                <!-- 1. Bagian Kiri Tiket -->
                <div class="flex-[2] bg-gradient-to-br relative p-4 md:p-8 flex flex-col justify-between"
                     :style="`background-image: linear-gradient(to bottom right, ${activeTheme.cardBg}, #000)`">
                    <div class="absolute inset-0 opacity-20" style="background-image: url('https://www.transparenttextures.com/patterns/stardust.png');"></div>
                    
                    <div class="flex justify-between items-start relative z-10 text-white">
                        <!-- LABEL ATAS DINAMIS -->
                        <div class="border border-white/30 px-2 py-0.5 md:px-3 md:py-1 text-[8px] md:text-xs font-bold uppercase tracking-widest">
                            {{ $settings->ticket_label_top ?? 'PUSAT SENI' }}
                        </div>
                        
                        <div class="text-right">
                            <!-- TANGGAL DINAMIS -->
                            <div class="text-lg md:text-2xl font-black leading-none">{{ \Carbon\Carbon::parse($settings->event_date)->day ?? '25' }}</div>
                            <div class="text-[8px] md:text-[10px] uppercase font-bold tracking-wider">{{ \Carbon\Carbon::parse($settings->event_date)->format('F') ?? 'AGUSTUS' }}</div>
                        </div>
                    </div>

                    <div class="relative z-10 text-center">
                        <!-- JUDUL TENGAH TIKET -->
                        <h2 class="text-2xl md:text-5xl font-black uppercase tracking-tighter text-white mb-1 md:mb-2 drop-shadow-lg leading-none">
                            {{ Str::limit($settings->ticket_label_title ?? $settings->hero_title, 15) }}
                        </h2>
                        <!-- LABEL BAWAH DINAMIS -->
                        <div class="text-[8px] md:text-sm font-bold tracking-[0.5em] uppercase" :style="`color: ${activeTheme.secondary}`">
                            {{ $settings->ticket_label_bottom ?? 'TAMPIL LIVE' }}
                        </div>
                    </div>

                    <div class="relative z-10 flex justify-between items-end">
                        <div class="border-2 rounded px-2 py-1 md:px-4 md:py-2 transform -rotate-3 bg-black/20 backdrop-blur-sm" :style="`border-color: ${activeTheme.primary}`">
                            <!-- LABEL HARGA -->
                            <div class="text-[6px] md:text-[8px] uppercase font-bold" :style="`color: ${activeTheme.primary}`">
                                {{ $settings->ticket_price_label ?? 'HARGA' }}
                            </div>
                            <!-- NOMINAL HARGA -->
                            <div class="text-sm md:text-xl font-bold text-white">
                                {{ $settings->ticket_price_display ?? 'Rp 750K++' }}
                            </div>
                        </div>
                        <div class="h-4 md:h-8 w-16 md:w-24 flex items-end justify-between gap-[1px] md:gap-[2px]">
                            <template x-for="i in 25"><div class="bg-white" :style="`width: ${Math.random() * 4}px; height: ${(Math.random() * 50 + 50)}%`"></div></template>
                        </div>
                    </div>
                </div>
                
                <!-- Garis Sobek Tiket -->
                <div class="relative w-0 border-r-2 border-dashed border-white/30" :style="`background-color: ${activeTheme.cardBg}`">
                    <div class="absolute -top-2 md:-top-3 -left-2 md:-left-3 w-4 h-4 md:w-6 md:h-6 rounded-full z-20" :style="`background-color: ${activeTheme.bg}`"></div>
                    <div class="absolute -bottom-2 md:-bottom-3 -left-2 md:-left-3 w-4 h-4 md:w-6 md:h-6 rounded-full z-20" :style="`background-color: ${activeTheme.bg}`"></div>
                </div>

                <!-- Bagian Kanan Tiket -->
                <div class="flex-1 bg-gradient-to-bl relative p-2 md:p-4 flex flex-col items-center justify-center"
                     :style="`background-image: linear-gradient(to bottom left, ${activeTheme.primary}40, ${activeTheme.cardBg})`">
                    <div class="absolute inset-0 opacity-20" style="background-image: url('https://www.transparenttextures.com/patterns/stardust.png');"></div>
                    <div class="relative z-10 h-full flex items-center justify-between w-full text-white">
                        <!-- LABEL VERTIKAL -->
                        <h3 class="text-xl md:text-3xl font-black uppercase tracking-widest whitespace-nowrap" style="writing-mode: vertical-rl; text-orientation: mixed;">
                            {{ Str::limit($settings->ticket_label_left ?? 'BISING NGE', 10, '') }}
                        </h3>
                        <div class="text-[6px] md:text-[8px] font-mono opacity-50 whitespace-nowrap" style="writing-mode: vertical-rl;">KONSER MUSIK</div>
                    </div>
                    <div class="absolute bottom-2 md:bottom-4 right-2 md:right-4 rotate-[-90deg] text-[8px] md:text-[10px] font-mono tracking-widest opacity-60 text-white">NO. 839201</div>
                </div>
            </div>

            <!-- Sticker -->
            <div class="absolute -top-4 -right-4 md:-top-6 md:-right-6 w-16 h-16 md:w-24 md:h-24 text-black rounded-full flex items-center justify-center font-black -rotate-12 shadow-lg animate-[bounce_3s_infinite] z-20"
                 :style="`background-color: ${activeTheme.secondary}`">
                <span class="text-center text-[8px] md:text-xs leading-tight">SOLD<br/>OUT<br/>BENTAR</span>
            </div>
        </div>
    </div>
</section>