<nav class="fixed inset-0 pointer-events-none z-50 p-6 md:p-12 flex flex-col justify-between">
    <div class="pointer-events-auto flex items-start justify-between w-full">
        <div class="group cursor-pointer">
            <h1 class="text-3xl font-black tracking-tighter leading-none transition-colors mix-blend-difference" :style="`color: ${activeTheme.text}`">
                RiBut<span class="transition-colors duration-500" :style="`color: ${activeTheme.primary}`">RiA</span>
                <span class="text-[10px] block font-mono tracking-[0.5em] text-gray-500 group-hover:tracking-[0.8em] transition-all">SISTEM TIKET</span>
            </h1>
        </div>
        
        <button @click="menuOpen = !menuOpen" 
                class="pointer-events-auto bg-white/5 backdrop-blur-md border border-white/10 w-14 h-14 rounded-full flex items-center justify-center transition-all duration-300 group hover:border-transparent"
                :style="`border-color: ${menuOpen ? activeTheme.primary : 'rgba(255,255,255,0.1)'}`">
            <i x-show="!menuOpen" data-lucide="menu" :style="`color: ${activeTheme.text}`"></i>
            <i x-show="menuOpen" data-lucide="x" :style="`color: ${activeTheme.text}`"></i>
        </button>
    </div>

    <div class="pointer-events-auto hidden md:block text-right absolute bottom-12 right-12">
        <div class="text-xs font-mono text-gray-500 mb-2">SCROLL KE BAWAH</div>
        <div class="w-[1px] h-16 bg-gray-800 ml-auto relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1/2 animate-[scrolldown_2s_infinite]" :style="`background-color: ${activeTheme.primary}`"></div>
        </div>
    </div>
</nav>