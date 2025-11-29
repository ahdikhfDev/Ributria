<section id="artists" class="py-32 px-6 relative z-10" :style="`background-color: ${activeTheme.bg}`">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-end justify-between mb-20 border-b border-white/20 pb-4">
            <h2 class="text-5xl md:text-7xl font-black text-transparent text-stroke-white">ARTIS</h2>
            <span class="font-mono text-sm text-gray-500">FASE 01 // 2025</span>
        </div>

        <div class="relative">
            <template x-for="(artist, idx) in lineup">
                <div class="group relative border-b border-white/10 py-10 cursor-pointer"
                     @mouseenter="hoveredArtist = artist"
                     @mouseleave="hoveredArtist = null">
                    <div class="flex flex-col md:flex-row md:items-center justify-between relative z-20 mix-blend-difference">
                        <h3 class="text-4xl md:text-6xl font-black uppercase text-gray-600 group-hover:text-white group-hover:translate-x-4 transition-all duration-300"
                            x-text="artist.name"></h3>
                        <div class="flex items-center gap-4 mt-2 md:mt-0 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="font-mono text-sm uppercase" :style="`color: ${activeTheme.primary}`" x-text="artist.genre"></span>
                            <i data-lucide="arrow-up-right" :style="`color: ${activeTheme.primary}`"></i>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Floating Hover Image (FIXED POSITION) -->
            <div x-show="hoveredArtist"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-x-10 rotate-12 scale-90"
                 x-transition:enter-end="opacity-100 translate-x-0 rotate-6 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-x-0 rotate-6 scale-100"
                 x-transition:leave-end="opacity-0 translate-x-10 rotate-12 scale-90"
                 class="fixed pointer-events-none z-30 hidden md:block"
                 style="top: 50%; right: 15%; transform: translateY(-50%) rotate(6deg); width: 350px; height: 450px;">
                <div class="relative w-full h-full border-4 bg-black shadow-2xl" :style="`border-color: ${activeTheme.primary}; box-shadow: 10px 10px 0px ${activeTheme.primary}40`">
                    <template x-if="hoveredArtist">
                        <img :src="hoveredArtist.img" class="w-full h-full object-cover filter grayscale contrast-125" />
                    </template>
                    <div class="absolute inset-0 mix-blend-multiply opacity-40" :style="`background-color: ${activeTheme.primary}`"></div>
                    
                    <!-- Decorative Glitch Elements -->
                    <div class="absolute -top-2 -left-2 w-4 h-4 bg-white z-10"></div>
                    <div class="absolute -bottom-2 -right-2 w-4 h-4 bg-white z-10"></div>
                    <div class="absolute bottom-4 left-[-20px] bg-black text-white px-2 py-1 text-xs font-mono -rotate-90 border border-white/20">PREVIEW</div>
                </div>
            </div>
        </div>
    </div>
</section>