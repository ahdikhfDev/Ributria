<div class="fixed bottom-6 right-6 z-50 flex flex-col items-end pointer-events-auto">
    <!-- Tombol Buka Tutup -->
    <button @click="chatOpen = !chatOpen" 
            class="w-14 h-14 rounded-full flex items-center justify-center transition-all duration-300 shadow-2xl hover:scale-110 active:scale-95 text-black"
            :style="`background-color: ${chatOpen ? activeTheme.primary : 'white'}; transform: ${chatOpen ? 'rotate(0deg)' : 'rotate(-12deg)'}; box-shadow: 0 0 20px ${activeTheme.primary}4D`">
        <i :data-lucide="chatOpen ? 'x' : 'bot'" class="w-6 h-6"></i>
    </button>

    <!-- Window Chat -->
    <div x-show="chatOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-10 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-10 scale-95"
         class="absolute bottom-20 right-0 w-[350px] md:w-[400px] bg-[#111] border rounded-xl overflow-hidden shadow-2xl flex flex-col h-[500px]" 
         :style="`border-color: ${activeTheme.primary}`"
         style="display: none;">
        
        <!--  Header  -->
        <div class="p-4 flex items-center justify-between shrink-0" :style="`background-color: ${activeTheme.primary}`">
            <div class="flex items-center gap-3">
                <i data-lucide="bot" class="w-6 h-6 text-black"></i>
                <div>
                    <h3 class="font-black text-black leading-none text-lg">CYBER ORACLE</h3>
                    <span class="text-[10px] font-mono font-bold text-black/70 tracking-wider">AI POWERED // ONLINE</span>
                </div>
            </div>
            <i data-lucide="sparkles" class="w-5 h-5 text-black animate-pulse"></i>
        </div>
        
        <!-- 2. Area Chat  -->
        <div id="chat-container" class="flex-1 overflow-y-auto p-4 space-y-4 bg-black/90 backdrop-blur-sm custom-scrollbar">
            <template x-for="msg in messages">
                <div class="flex" :class="msg.role === 'user' ? 'justify-end' : 'justify-start'">
                    <div class="max-w-[80%] p-3 text-sm font-mono leading-relaxed shadow-lg"
                         :class="msg.role === 'user' ? 'bg-white text-black rounded-l-xl rounded-tr-xl' : 'bg-[#1a1a1a] border rounded-r-xl rounded-tl-xl'"
                         :style="`color: ${msg.role === 'user' ? 'black' : activeTheme.primary}; border-color: ${msg.role === 'user' ? 'transparent' : activeTheme.primary + '4D'}`"
                         x-text="msg.text">
                    </div>
                </div>
            </template>
            
            <!-- Loading Indicator -->
            <div x-show="isAiLoading" class="flex justify-start">
                <div class="bg-[#1a1a1a] p-3 rounded-r-xl rounded-tl-xl border flex items-center gap-2" :style="`border-color: ${activeTheme.primary}4D`">
                    <i data-lucide="loader" class="w-4 h-4 animate-spin" :style="`color: ${activeTheme.primary}`"></i>
                    <span class="text-[10px] text-gray-500 font-mono animate-pulse">LAGI MIKIR...</span>
                </div>
            </div>
        </div>

        <!-- Input massage -->
        <div class="p-4 bg-[#111] border-t border-white/10 shrink-0 z-20">
            <div class="flex gap-2 relative">
                <input type="text" 
                       x-model="inputMsg" 
                       @keydown.enter="handleSend" 
                       placeholder="Tanya Oracle..." 
                       class="w-full bg-[#0a0a0a] border border-white/20 text-white px-4 py-3 pr-12 rounded-lg font-mono text-sm focus:outline-none placeholder:text-gray-600 focus:border-opacity-100 transition-colors shadow-inner" 
                       :style="`border-color: ${activeTheme.primary}; --tw-ring-color: ${activeTheme.primary}`" />
                
                <button @click="handleSend" 
                        :disabled="!inputMsg.trim() || isAiLoading" 
                        class="absolute right-2 top-1/2 -translate-y-1/2 p-2 text-black rounded hover:bg-white disabled:opacity-50 transition-colors" 
                        :style="`background-color: ${activeTheme.primary}`">
                    <i data-lucide="send" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
    </div>
</div>