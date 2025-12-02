<!-- Player cuma muncul kalau ada lagu di playlist -->
<div class="fixed bottom-6 left-6 z-50 hidden md:flex items-center gap-4 bg-[#111] border border-white/20 p-2 pr-6 rounded-full pointer-events-auto shadow-2xl backdrop-blur-md"
     x-show="tracks && tracks.length > 0" 
     style="display: none;"> 
    
    <!-- Album Art Animasi -->
    <div class="relative w-12 h-12 rounded-full overflow-hidden border-2 animate-spin-slow bg-black" 
         :style="`animation-play-state: ${isPlaying ? 'running' : 'paused'}; border-color: ${activeTheme.primary}`">
        
        <!-- Gambar Vinyl / CD -->
        <img src="https://cdn.pixabay.com/photo/2018/05/08/21/28/vinyl-3384002_1280.png" 
             alt="Spinning Disc" 
             class="w-full h-full object-cover opacity-80">

        <!-- Overlay Warna Tema -->
        <div class="absolute inset-0 mix-blend-overlay" :style="`background-color: ${activeTheme.primary}`"></div>
        
        <!-- Lubang Tengah  -->
        <div class="absolute top-1/2 left-1/2 w-3 h-3 bg-[#111] rounded-full transform -translate-x-1/2 -translate-y-1/2 border border-white/30"></div>
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