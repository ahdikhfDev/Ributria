<section id="tickets" class="py-24 relative z-10" :style="`background-color: ${activeTheme.bg}`">
    <div class="absolute inset-0 opacity-20 pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <!-- Header -->
        <div class="text-center mb-20">
            <h2 class="text-5xl md:text-6xl font-black uppercase mb-4" :style="`color: ${activeTheme.text}`">PILIH<span :style="`color: ${activeTheme.primary}`"> AKSES</span></h2>
            <p class="text-gray-500 font-mono">TEMPAT TERBATAS. AMANIN POSISI LO SEKARANG.</p>
        </div>

        <!-- Grid Tiket -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <template x-for="(tier, idx) in tickets">
                <div class="relative group transition-transform duration-300" 
                     :class="{'hover:-translate-y-2': !tier.is_sold_out && tier.stock > 0, 'opacity-75 grayscale': tier.is_sold_out || tier.stock <= 0}">
                    
                    <!-- Label Paling Laris (Glow) - Cuma muncul kalau gak sold out -->
                    <div x-show="tier.glow && !tier.is_sold_out && tier.stock > 0" class="absolute -top-4 left-1/2 -translate-x-1/2 text-black px-4 py-1 font-black text-xs uppercase tracking-widest rounded-t-sm z-30" :style="`background-color: ${activeTheme.primary}`">
                        PALING LARIS
                    </div>

                    <!-- Label SOLD OUT (Overlay) -->
                    <div x-show="tier.is_sold_out || tier.stock <= 0" class="absolute inset-0 z-40 flex items-center justify-center pointer-events-none">
                        <div class="bg-red-600 text-white text-4xl font-black uppercase tracking-widest -rotate-12 border-4 border-white px-4 py-2 shadow-xl">
                            SOLD OUT
                        </div>
                    </div>
                    
                    <div class="relative w-full overflow-hidden">
                        <!-- 1. Bagian Atas Tiket -->
                        <div class="p-8 border-x-2 border-t-2 rounded-t-2xl relative"
                             :style="`background-color: ${tier.glow ? activeTheme.cardBg : '#111'}; border-color: ${tier.is_sold_out || tier.stock <= 0 ? '#333' : (tier.borderColor ? (idx === 0 ? '#4b5563' : '#eab308') : activeTheme.primary)}`">
                            
                            <div class="flex justify-between items-start mb-6">
                                <div class="p-4 rounded-full border-2 w-max bg-black/50"
                                     :style="`border-color: ${tier.glow ? activeTheme.primary : (tier.textColor === 'text-yellow-500' ? '#eab308' : '#9ca3af')}; color: ${tier.glow ? activeTheme.primary : (tier.textColor === 'text-yellow-500' ? '#eab308' : '#9ca3af')}`">
                                    <i :data-lucide="tier.icon" class="w-6 h-6"></i>
                                </div>

                                <!-- TAMPILAN STOK -->
                                <div class="text-right">
                                    <div class="text-[10px] text-gray-500 uppercase tracking-wider mb-1">SISA STOK</div>
                                    <div class="font-mono font-bold" 
                                         :class="tier.stock < 10 ? 'text-red-500 animate-pulse' : 'text-white'"
                                         x-text="tier.stock > 0 ? tier.stock : 'HABIS'"></div>
                                </div>
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

                        <!-- 2. Pembatas Garis Putus-putus -->
                        <div class="relative h-6 w-full border-x-2 flex items-center bg-[#111]"
                             :style="`background-color: ${tier.glow ? activeTheme.cardBg : '#111'}; border-color: ${tier.is_sold_out || tier.stock <= 0 ? '#333' : (tier.borderColor ? (idx === 0 ? '#4b5563' : '#eab308') : activeTheme.primary)}`">
                            <div class="w-full border-b-2 border-dashed border-gray-600/50"></div>
                            <div class="absolute left-[-10px] w-5 h-5 rounded-full z-20" :style="`background-color: ${activeTheme.bg}; border-right: 2px solid ${tier.is_sold_out || tier.stock <= 0 ? '#333' : (tier.glow ? activeTheme.primary : (idx === 0 ? '#4b5563' : '#eab308'))}`"></div>
                            <div class="absolute right-[-10px] w-5 h-5 rounded-full z-20" :style="`background-color: ${activeTheme.bg}; border-left: 2px solid ${tier.is_sold_out || tier.stock <= 0 ? '#333' : (tier.glow ? activeTheme.primary : (idx === 0 ? '#4b5563' : '#eab308'))}`"></div>
                        </div>

                        <!-- 3. Bagian Bawah & Tombol -->
                        <div class="p-6 border-x-2 border-b-2 rounded-b-2xl bg-black/40 flex flex-col items-center"
                             :style="`background-color: ${tier.glow ? activeTheme.cardBg : '#0d0d0d'}; border-color: ${tier.is_sold_out || tier.stock <= 0 ? '#333' : (tier.borderColor ? (idx === 0 ? '#4b5563' : '#eab308') : activeTheme.primary)}`">
                            <div class="w-full h-8 flex justify-center gap-[2px] mb-4 opacity-50">
                                <template x-for="i in 30"><div class="bg-white" :style="`width: ${Math.random() * 3}px; height: 100%`"></div></template>
                            </div>
                            
                            <!-- TOMBOL ACTION -->
                            <!-- Jika Stok > 0 & Tidak Sold Out: Tombol Normal -->
                            <template x-if="!tier.is_sold_out && tier.stock > 0">
                                <button @click="openCheckout(tier)"
                                        class="w-full py-3 font-black uppercase tracking-widest transition-all border-2 hover:bg-white hover:text-black text-white text-sm bg-transparent cursor-pointer"
                                        :style="`border-color: ${tier.glow ? activeTheme.primary : (tier.textColor === 'text-yellow-500' ? '#eab308' : '#9ca3af')}`">
                                    AMBIL TIKET
                                </button>
                            </template>

                            <!-- Jika Habis: Tombol Disabled -->
                            <template x-if="tier.is_sold_out || tier.stock <= 0">
                                <button disabled
                                        class="w-full py-3 font-black uppercase tracking-widest border-2 border-gray-800 text-gray-600 text-sm bg-gray-900 cursor-not-allowed">
                                    TIKET HABIS
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- === MODAL POP-UP CHECKOUT (SAMA SEPERTI SEBELUMNYA) === -->
    <div x-show="checkoutOpen" 
         class="fixed inset-0 z-50 flex items-center justify-center px-4"
         style="display: none;">
        
        <div x-show="checkoutOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute inset-0 bg-black/90 backdrop-blur-sm" 
             @click="closeCheckout"></div>

        <div x-show="checkoutOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90 translate-y-10"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-90 translate-y-10"
             class="relative bg-[#111] border-2 w-full max-w-lg p-8 shadow-2xl rounded-xl overflow-hidden z-50"
             :style="`border-color: ${activeTheme.primary}`">
            
            <div class="absolute top-0 right-0 p-4 opacity-20 pointer-events-none">
                <i data-lucide="ticket" class="w-32 h-32 text-white"></i>
            </div>

            <div class="relative z-10">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-2xl font-black uppercase text-white">DATA <span :style="`color: ${activeTheme.primary}`">PEMESAN</span></h3>
                        <p class="text-gray-400 text-sm font-mono mt-1">
                            TIKET: <span class="text-white font-bold" x-text="selectedTicket?.name"></span>
                        </p>
                    </div>
                    <button @click="closeCheckout" class="text-gray-500 hover:text-white transition-colors"><i data-lucide="x" class="w-6 h-6"></i></button>
                </div>

                <form action="{{ route('ticket.checkout') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="ticket_id" :value="selectedTicket?.id">

                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Nama Lengkap</label>
                        <input type="text" name="guest_name" required x-model="checkoutForm.name" 
                               class="w-full bg-black border border-gray-700 p-3 text-white focus:outline-none focus:border-white transition-colors placeholder-gray-600 rounded"
                               placeholder="Nama lo siapa?">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Email</label>
                            <input type="email" name="guest_email" required x-model="checkoutForm.email" 
                                   class="w-full bg-black border border-gray-700 p-3 text-white focus:outline-none focus:border-white transition-colors placeholder-gray-600 rounded"
                                   placeholder="email@contoh.com">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">WhatsApp</label>
                            <input type="text" name="guest_phone" required x-model="checkoutForm.phone" 
                                   class="w-full bg-black border border-gray-700 p-3 text-white focus:outline-none focus:border-white transition-colors placeholder-gray-600 rounded"
                                   placeholder="0812...">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Jumlah Tiket (Max 10)</label>
                        <div class="flex items-center gap-4">
                            <button type="button" @click="if(checkoutForm.qty > 1) checkoutForm.qty--" class="w-12 h-12 bg-gray-800 text-white font-bold hover:bg-gray-700 rounded transition-colors">-</button>
                            <input type="number" name="quantity" readonly x-model="checkoutForm.qty" class="w-full bg-black border border-gray-700 p-3 text-center text-white font-bold rounded h-12">
                            <!-- Logic: Gak bisa tambah kalau melebihi stok -->
                            <button type="button" 
                                    @click="if(checkoutForm.qty < 10 && checkoutForm.qty < selectedTicket.stock) checkoutForm.qty++" 
                                    class="w-12 h-12 bg-gray-800 text-white font-bold hover:bg-gray-700 rounded transition-colors disabled:opacity-50"
                                    :disabled="checkoutForm.qty >= selectedTicket?.stock">+</button>
                        </div>
                        <div class="text-xs text-gray-500 mt-1" x-show="selectedTicket?.stock < 10">
                            *Maksimal beli sesuai sisa stok
                        </div>
                    </div>

                    <div class="p-4 bg-white/5 border border-white/10 mt-6 flex justify-between items-center rounded">
                        <span class="text-sm text-gray-400 font-mono">ESTIMASI TOTAL</span>
                        <span class="text-2xl font-black text-white" x-text="estimatedTotal"></span>
                    </div>

                    <button type="submit" 
                            class="w-full py-4 font-black uppercase text-black hover:bg-white transition-all mt-4 relative overflow-hidden group rounded shadow-lg hover:shadow-white/20"
                            :style="`background-color: ${activeTheme.primary}`">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            LANJUT PEMBAYARAN <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>