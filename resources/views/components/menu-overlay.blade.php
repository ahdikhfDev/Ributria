<!-- MENU OVERLAY FULLSCREEN -->
<div class="fixed inset-0 bg-[#0a0a0a] z-40 transition-transform duration-500 ease-in-out flex items-center justify-center"
     :class="menuOpen ? 'translate-y-0' : '-translate-y-full'"
     :style="`background-color: ${activeTheme.bg}`">
    
    <div class="flex flex-col gap-6 text-center">
        <!-- Loop Menu Item dengan ID Link -->
        <template x-for="link in [
            { text: 'BERANDA', id: '#' },
            { text: 'ARTIS', id: '#artists' },
            { text: 'TIKET', id: '#tickets' },
            { text: 'INFO', id: '#newsletter' }
        ]">
            <a :href="link.id" 
               class="text-5xl md:text-7xl font-black text-transparent text-stroke-white hover:text-stroke-none transition-all duration-300 tracking-tighter"
               @click="menuOpen = false"
               @mouseenter="$el.style.color = activeTheme.primary"
               @mouseleave="$el.style.color = 'transparent'"
               x-text="link.text">
            </a>
        </template>
    </div>
</div>