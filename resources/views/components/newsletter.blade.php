<section id="newsletter" class="py-20 relative border-t border-white/10 bg-black overflow-hidden">
    <div class="container mx-auto px-6 relative z-10 flex flex-col md:flex-row items-center justify-between gap-12">
        <div class="md:w-1/2 text-white">
            <h2 class="text-4xl font-black uppercase mb-4" :style="`color: ${activeTheme.text}`">GABUNG <span :style="`color: ${activeTheme.primary}`">GERAKAN KITA</span></h2>
            <p class="text-gray-500 font-mono">Dapetin info eksklusif, bocoran lineup, dan kode VIP langsung ke inbox lo.</p>
        </div>
        
        <div class="md:w-1/2 w-full">
            <!-- PESAN SUKSES DARI CONTROLLER -->
            @if(session('success'))
                <div class="mb-4 p-3 border border-green-500 bg-green-500/10 text-green-500 font-mono text-sm font-bold flex items-center gap-2 animate-pulse">
                    <i data-lucide="check" class="w-4 h-4"></i> {{ session('success') }}
                </div>
            @endif

            <!-- PESAN ERROR VALIDASI -->
            @error('email')
                <div class="mb-4 p-3 border border-red-500 bg-red-500/10 text-red-500 font-mono text-sm font-bold flex items-center gap-2">
                    <i data-lucide="alert-triangle" class="w-4 h-4"></i> {{ $message }}
                </div>
            @enderror

            <!-- FORM STANDAR (TANPA JS) -->
            <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex gap-4">
                @csrf
                
                <input type="email" 
                       name="email" 
                       required
                       value="{{ old('email') }}"
                       placeholder="MASUKIN EMAIL LO" 
                       class="w-full bg-[#111] border border-white/20 p-4 text-white font-mono focus:outline-none focus:border-opacity-100 transition-colors" 
                       :style="`border-color: ${activeTheme.primary}`" />
                
                <button type="submit" 
                        class="text-black font-bold px-8 hover:bg-white transition-colors uppercase" 
                        :style="`background-color: ${activeTheme.primary}`">
                    <i data-lucide="mail"></i>
                </button>
            </form>
        </div>
    </div>
</section>