<section id="tickets" class="py-24 relative z-10" :style="`background-color: ${activeTheme.bg}`">
    <div class="absolute inset-0 opacity-20 pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');"></div>
    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-20">
            <h2 class="text-5xl md:text-6xl font-black uppercase mb-4" :style="`color: ${activeTheme.text}`">PILIH AKSES <span :style="`color: ${activeTheme.primary}`">LO</span></h2>
            <p class="text-gray-500 font-mono">TEMPAT TERBATAS. AMANIN POSISI LO SEKARANG.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <template x-for="(tier, idx) in tickets">
                <div class="relative group transition-transform duration-300 hover:-translate-y-2">
                    <div x-show="tier.glow" class="absolute -top-4 left-1/2 -translate-x-1/2 text-black px-4 py-1 font-black text-xs uppercase tracking-widest rounded-t-sm z-30" :style="`background-color: ${activeTheme.primary}`">
                        PALING LARIS
                    </div>
                    
                    <!-- VERTICAL TICKET CARD -->
                    <div class="relative w-full overflow-hidden">
                        <!-- 1. TOP PART -->
                        <div class="p-8 border-x-2 border-t-2 rounded-t-2xl relative"
                             :style="`background-color: ${tier.glow ? activeTheme.cardBg : '#111'}; border-color: ${tier.borderColor ? (idx === 0 ? '#4b5563' : '#eab308') : activeTheme.primary}`">
                            
                            <div class="mb-6 p-4 rounded-full border-2 w-max bg-black/50"
                                 :style="`border-color: ${tier.glow ? activeTheme.primary : (tier.textColor === 'text-yellow-500' ? '#eab308' : '#9ca3af')}; color: ${tier.glow ? activeTheme.primary : (tier.textColor === 'text-yellow-500' ? '#eab308' : '#9ca3af')}`">
                                <i :data-lucide="tier.icon" class="w-6 h-6"></i>
                            </div>

                            <h3 class="text-3xl font-black uppercase italic mb-2 text-white" x-text="tier.name"></h3>
                            <div class="text-3xl font-bold mb-8" :style="`color: ${tier.glow ? activeTheme.primary : (tier.textColor === 'text-yellow-500' ? '#eab308' : '#9ca3af')}`" x-text="tier.price"></div>

                            <ul class="space-y-4 mb-4">
                                <template x-for="feat in tier.features">
                                    <li class="flex items-center gap-3 text-sm text-gray-400 font-mono">
                                        <i data-lucide="check-circle" class="w-4 h-4" :style="`color: ${tier.glow ? activeTheme.primary : (tier.textColor === 'text-yellow-500' ? '#eab308' : '#9ca3af')}`"></i>
                                        <span x-text="feat"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>

                        <!-- 2. DIVIDER -->
                        <div class="relative h-6 w-full border-x-2 flex items-center bg-[#111]"
                             :style="`background-color: ${tier.glow ? activeTheme.cardBg : '#111'}; border-color: ${tier.borderColor ? (idx === 0 ? '#4b5563' : '#eab308') : activeTheme.primary}`">
                            <div class="w-full border-b-2 border-dashed border-gray-600/50"></div>
                            <div class="absolute left-[-10px] w-5 h-5 rounded-full z-20" :style="`background-color: ${activeTheme.bg}; border-right: 2px solid ${tier.glow ? activeTheme.primary : (idx === 0 ? '#4b5563' : '#eab308')}`"></div>
                            <div class="absolute right-[-10px] w-5 h-5 rounded-full z-20" :style="`background-color: ${activeTheme.bg}; border-left: 2px solid ${tier.glow ? activeTheme.primary : (idx === 0 ? '#4b5563' : '#eab308')}`"></div>
                        </div>

                        <!-- 3. BOTTOM PART -->
                        <div class="p-6 border-x-2 border-b-2 rounded-b-2xl bg-black/40 flex flex-col items-center"
                             :style="`background-color: ${tier.glow ? activeTheme.cardBg : '#0d0d0d'}; border-color: ${tier.borderColor ? (idx === 0 ? '#4b5563' : '#eab308') : activeTheme.primary}`">
                            <div class="w-full h-8 flex justify-center gap-[2px] mb-4 opacity-50">
                                <template x-for="i in 30"><div class="bg-white" :style="`width: ${Math.random() * 3}px; height: 100%`"></div></template>
                            </div>
                            <button class="w-full py-3 font-black uppercase tracking-widest transition-all border-2 hover:bg-white hover:text-black text-white text-sm bg-transparent"
                                    :style="`border-color: ${tier.glow ? activeTheme.primary : (tier.textColor === 'text-yellow-500' ? '#eab308' : '#9ca3af')}`">
                                AMBIL TIKET
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</section>