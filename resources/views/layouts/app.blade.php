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
        <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/9000.0.1/themes/prism.css" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/thememode.js'])

        <!-- Import method throught Vite port without type module attribute -->
        <script src="{{ env('APP_VITE_URL') }}/resources/js/hubsidebar.js" async></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js"></script>

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

        <x-layout.modal name="send-report-modal" maxWidth="2xl" display="justify-between">
            <x-slot name="title">
                <div class="py-4 text-center">
                    Send Report
                </div>
                <div class="cross-menu" @click.prevent="show = false">
                    &times;
                </div>
            </x-slot>

            <x-slot name="body">
                <form id="report-form" x-ref="report-form" action="{{ route('messenger.send-reports') }}" method="get" class="flex flex-col justify-between items-center">
                    @csrf
                    <div class="w-3/4 py-5">
                        <x-jet-label for="subject" value="{{ __('Subject') }}" />
                        <x-jet-input id="send-report-subject" x-ref="sendreportsubject" type="text" name="subject" class="mt-1 block w-full text-slate-700/70" value="{{ old('subject', '' ) }}"/>
                        <x-jet-input-error for="subject" class="mt-2" />
                        <p id="send-report-error-subject" class="text-sm text-red-600"></p>
                    </div>

                    <div class="w-3/4 py-5">
                        <x-jet-label for="message" value="{{ __('Message') }}" />

                        <textarea name="message" id="send-report-message" x-ref="sendreportmessage" cols="30" rows="5" maxlength="500"
                                  class="w-full block mt-1 rounded-md transition border border-gray-300 text-slate-700/70
                                        dark:bg-[rgb(255,255,255)]/20 dark:text-slate-100
                                        focus:outline-none focus:ring-1 focus:saturate-150 focus:ring-violet-600
                                        dark:focus:shadow-outter-lg dark:focus:ring-transparent
                                        dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30"
                        >{{ old('message', '') }}</textarea>
                        <x-jet-input-error for="message" class="mt-2" />
                        <p id="send-report-error-message" class="text-sm text-red-600"></p>

                    </div>

                    <div class="w-full flex justify-end items-center py-5 pr-5">
                        <x-jet-button id="send-reports">
                            Send Report
                        </x-jet-button>
                    </div>

                </form>

            </x-slot>

            <x-slot name="footer"></x-slot>
        </x-layout.modal>
        <script>
            window.addEventListener('DOMContentLoaded', (eDCL) => {
                iodine = new Iodine();

                const rules = {
                    subject: ['required', 'string', 'maxLength:500'],
                    message: ['required', 'string', 'maxLength:500'],
                };

                document.getElementById('send-report-subject')
                    .addEventListener('blur', (eBlur) => {
                        let subject =  document.getElementById('send-report-subject').value;
                        let assert = iodine.assert(subject, rules.subject);

                        if (!assert.valid) {
                            document.getElementById('send-report-error-subject').textContent = assert.error;
                        } else {
                            document.getElementById('send-report-error-subject').textContent = '';
                        }
                    });

                document.getElementById('send-report-message')
                    .addEventListener('blur', (eBlur) => {
                        let message =  document.getElementById('send-report-message').value;
                        let assert = iodine.assert(message, rules.message);
                        if (!assert.valid) {
                            document.getElementById('send-report-error-message').textContent = assert.error;
                        } else {
                            document.getElementById('send-report-error-message').textContent = '';
                        }
                    });


                document.getElementById('send-reports').addEventListener('click', (eClick) => {

                    let subjectValue =  document.getElementById('send-report-subject').value;
                    let messageValue =  document.getElementById('send-report-message').value;

                    let subject = iodine.assert(subjectValue, rules.subject);
                    let url = iodine.assert(urlValue, rules.url);
                    let message = iodine.assert(messageValue, rules.message);

                    if (!subject.valid && !message.valid) {
                        eClick.preventDefault();
                        eClick.stopImmediatePropagation();
                        if (!subject.valid) {
                            document.getElementById('send-report-error-subject').textContent = subject.error;
                        } else {
                            document.getElementById('send-report-error-subject').textContent = '';
                        }

                        if (!message.valid) {
                            document.getElementById('send-report-error-message').textContent = message.error;
                        } else {
                            document.getElementById('send-report-error-message').textContent = '';
                        }
                    }
                })
            })

        </script>
        @livewireScripts
        <script>
            window.Laravel = {!! json_encode(['userId' => auth()->check() ? auth()->user()->id : null]) !!}
        </script>

        @if (session()->has('syncStatus'))
            <x-layout.flash type="{{ session('syncStatus') }}">
                {{ session('syncMessage') }}
            </x-layout.flash>
        @endif
    </body>
</html>
