<div class="fixed top-24 left-6 z-50">
    <button @click="showAdminPanel = !showAdminPanel" class="bg-white/10 hover:bg-white/20 backdrop-blur text-xs font-bold px-3 py-2 rounded border border-white/20 flex items-center gap-2 transition-all text-white">
        <i data-lucide="settings" class="w-3 h-3"></i> TEMA ADMIN
    </button>
    
    <div x-show="showAdminPanel" x-transition class="mt-2 p-4 bg-[#111] border border-white/20 rounded-lg shadow-xl w-48 text-white" style="display: none;">
        <div class="text-[10px] uppercase font-bold text-gray-500 mb-2">Pilih Tema Event</div>
        <div class="space-y-2">
            <template x-for="(theme, key) in themes">
                <button @click="setTheme(key)" class="w-full text-left px-3 py-2 rounded text-xs font-bold flex items-center gap-2" :class="currentThemeName === key ? 'bg-white text-black' : 'hover:bg-white/10'">
                    <div class="w-2 h-2 rounded-full" :style="`background-color: ${theme.primary}`"></div>
                    <span x-text="theme.name"></span>
                </button>
            </template>
        </div>
    </div>
</div>