<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $settings->hero_title ?? 'RiButRiA - Live Concert' }}</title>
    
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;800&family=Inter:wght@400;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: {{ $settings->primary_color ?? '#ff1f1f' }};
            --secondary-color: {{ $settings->secondary_color ?? '#ccff00' }};
            --bg-color: {{ $settings->background_color ?? '#050505' }};
        }
    </style>
</head>

<body x-data="appData(
        {{ Js::from($artists) }}, 
        {{ Js::from($tickets) }}, 
        {{ Js::from($settings) }},
        {{ Js::from($tracks) }}
      )" 
      class="min-h-screen text-white transition-colors duration-500"
      :style="`background-color: ${activeTheme.bg}; color: ${activeTheme.text};`"
      @mousemove="handleMouseMove($event)">

    <div class="fixed inset-0 pointer-events-none z-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')]" style="opacity: 0.2"></div>
    
    <div class="fixed top-1/2 left-0 w-full -translate-y-1/2 -rotate-12 scale-110 opacity-[0.03] pointer-events-none z-0 whitespace-nowrap overflow-hidden select-none">
        <div class="animate-marquee text-[20vw] font-black uppercase leading-none">
            RIBUTRIA FEST • CHAOS IN HARMONY • MUSIC & ART • RIBUTRIA FEST • 
        </div>
    </div>

    <main>
        @yield('content')
    </main>

    @include('components.sonic-deck')
    @include('components.chat-oracle')
    @include('components.menu-overlay')

</body>
</html>