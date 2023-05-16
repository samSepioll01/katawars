<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="
            @if (auth()->user()?->email_verified_at)
                {{ auth()->user()->profile->is_darkmode ? 'dark' : '' }}
            @else
                {{ session('theme') ?? '' }}
            @endif
    "
>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="last_activity" content="{{ auth()->user()->sessions->first()->last_activity }}">

        <title>{{ config('app.name', 'KataWars') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="shortcut icon" type="image/png" href="{{ env('AWS_APP_URL') }}/logo/logo7.png"/>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/thememode.js'])

        <!-- Import method throught Vite port without type module attribute -->
        <script src="{{ env('APP_VITE_URL') }}/resources/js/hubsidebar.js" async></script>
        <!-- Styles -->
        @livewireStyles
    </head>
    <body x-data="hubSidebar()" :class="{ 'overflow-hidden': responsiveOpen}"
          class="min-h-screen bg-slate-100 dark:bg-gradient-to-tr dark:from-cyan-700 dark:via-cyan-500 dark:to-violet-500 transition-all duration-300
            @if (auth()->user()?->email_verified_at)
                {{ auth()->user()->profile->is_darkmode ? 'scrollbar-dark' : 'scrollbar-light' }}
            @else
                {{ session('theme') === 'dark' ? 'scrollbar-dark' :  'scrollbar-light' }}
            @endif
          "
    >
        <x-jet-banner />
        @livewire('navigation-menu')

        <x-layout.sidebar>
            <x-layout.sidebar-content />
        </x-layout.sidebar>

        <!-- Page Content -->
        <main class="font-sans text-gray-900 antialiased dark:bg-slate-900/70 min-h-screen">
            {{ $slot }}
        </main>
        <x-layout.footer />
        @stack('modals')
        @livewireScripts
        <script>
            window.Laravel = {!! json_encode(['userId' => auth()->check() ? auth()->user()->id : null]) !!}
        </script>
    </body>
</html>
