@extends('layouts.app')

@section('content')
    
    @include('components.navbar')
    
    @include('components.hero')

    <div class="w-full text-black overflow-hidden py-4 border-y-4 border-black -rotate-1 relative z-20 shadow-lg"
         :style="`background-color: ${activeTheme.primary}`">
        <div class="animate-marquee whitespace-nowrap font-black text-3xl uppercase flex gap-12">
            <template x-for="i in 8">
                <span class="flex items-center gap-4">
                    AMBIL TIKET LO <i data-lucide="star" class="fill-black w-6 h-6"></i> JANGAN LEWATIN KESERUANNYA <i data-lucide="zap" class="fill-black w-6 h-6"></i>
                </span>
            </template>
        </div>
    </div>

    @include('components.lineup')
    
    @include('components.tickets')
    
    @include('components.newsletter')
    
    @include('components.footer')

@endsection 