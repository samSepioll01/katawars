<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>{{ config('app.name', 'KataWars') }}</title>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="shortcut icon" type="image/png" href="storage/logo/logo7.png"/>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/thememode.js'])
        <!-- Import method throught Vite port without type module attribute -->
        <script src="{{ env('APP_VITE_URL') }}/resources/js/hubsidebar.js" async></script>
    </head>
    <body
        x-data="hubSidebar()"
        :class="{ 'overflow-hidden': responsiveOpen}"
        class=" @if(Request::routeIs('home'))
                    dark:bg-slate-900
                @else
                    dark:bg-gradient-to-tr dark:from-cyan-700 dark:via-cyan-500 dark:to-violet-500
                @endif
                    bg-slate-100 transition-all duration-300"
    >
        @livewire('navigation-menu')

        @auth
            <x-layout.sidebar>
                <x-layout.sidebar-content />
            </x-layout.sidebar>
        @endauth

        <main class="font-sans text-gray-900 antialiased @unless(Request::routeIs('home')) dark:bg-slate-900/70 @endunless">
            {{ $slot }}
        </main>
        <x-layout.footer />
    </body>
</html>
