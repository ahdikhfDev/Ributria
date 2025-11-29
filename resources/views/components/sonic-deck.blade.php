<!-- Player cuma muncul kalau ada lagu di playlist -->
<div class="fixed bottom-6 left-6 z-50 hidden md:flex items-center gap-4 bg-[#111] border border-white/20 p-2 pr-6 rounded-full pointer-events-auto shadow-2xl backdrop-blur-md"
     x-show="tracks && tracks.length > 0" 
     style="display: none;"> <!-- Default hidden biar gak glitcy pas load -->
    
    <!-- Album Art Animasi -->
    <div class="relative w-12 h-12 rounded-full overflow-hidden border animate-spin-slow" 
         :style="`animation-play-state: ${isPlaying ? 'running' : 'paused'}; border-color: ${activeTheme.primary}`">
        <!-- Placeholder Cover Art (Hitam Polos) -->
        <div class="w-full h-full bg-gray-800"></div> 
        <div class="absolute inset-0 mix-blend-overlay" :style="`background-color: ${activeTheme.primary}`"></div>
    </div>
    
    <!-- Info Lagu -->
    <div class="flex flex-col">
        <div class="text-[10px] font-bold tracking-wider animate-pulse" :style="`color: ${activeTheme.primary}`">NOW PLAYING</div>
        
        <!-- JUDUL LAGU DINAMIS -->
        <div class="text-xs font-mono font-bold text-white max-w-[150px] truncate" x-text="currentTrack?.title || 'Loading...'"></div>
        
        <!-- NAMA ARTIS DINAMIS -->
        <div class="text-[10px] font-mono text-gray-400 truncate" x-text="currentTrack?.artist || 'Unknown'"></div>
    </div>
    
    <div class="h-8 w-[1px] bg-white/20 mx-2"></div>
    
    <!-- Tombol Kontrol -->
    <div class="flex items-center gap-3">
        <button class="hover:text-white transition-transform active:scale-90" @click="prevTrack">
            <i data-lucide="skip-back" class="w-4 h-4"></i>
        </button>
        
        <button @click="togglePlay" 
                class="w-8 h-8 bg-white text-black rounded-full flex items-center justify-center transition-all hover:scale-110 active:scale-95">
            <!-- Icon berubah Play/Pause -->
            <i :data-lucide="isPlaying ? 'pause' : 'play'" class="w-4 h-4 fill-current ml-0.5"></i>
        </button>
        
        <button class="hover:text-white transition-transform active:scale-90" @click="nextTrack">
            <i data-lucide="skip-forward" class="w-4 h-4"></i>
        </button>
    </div>
    
    <!-- Visualizer Bar -->
    <div class="flex gap-[2px] items-end h-4 ml-2">
        <template x-for="i in 5">
            <div class="w-[3px]" :style="`background-color: ${activeTheme.primary}; height: ${isPlaying ? Math.random() * 100 : 20}%; transition: height 0.1s ease`"></div>
        </template>
    </div>
</div>