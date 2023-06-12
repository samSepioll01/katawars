<nav
    x-data="{idiom: false}"
    class="sticky top-0 z-40 w-full backdrop-blur flex-none transition-colors duration-300 lg:z-50
           lg:border-b lg:border-slate-900/10 dark:border-slate-50/[0.06] bg-white/90
           supports-backdrop-blur:bg-white/40 dark:bg-gray-900/90"
>

    <!-- Primary Navigation Menu -->
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">

                <!-- Hub SideBar Menu -->
                @auth
                    <x-layout.hub class="hidden sm:inline-flex sm:items-start" />
                @endauth

                @php
                    $authRoute = auth()?->user()?->hasRole(['superadmin', 'admin']) ? 'admin.panel' : 'dashboard';
                @endphp

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="@auth() {{ route($authRoute) }} @else {{ route('home') }}@endauth" class=" flex flex-row">
                        <x-logo id="logo" type="text" class="rounded w-36 bg-white/80 dark:bg-slate-900/80 transition duration-300" />
                    </a>
                </div>

                <!-- Navigation Links -->
                @auth
                    @if (!request()->routeIs('dashboard'))
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-jet-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-jet-nav-link>
                        </div>
                    @endif

                    @admin(!request()->is('admin/*'))
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex z-10">
                            <x-jet-nav-link href="{{ route('admin.panel') }}">
                                {{ __('Admin') }}
                            </x-jet-nav-link>
                        </div>
                    @endadmin
                @endauth
            </div>

            <div class="w-full flex items-center justify-center sm:justify-end ml-6">

                <!-- Change Mode Button -->
                <button id="btn-mode" class="h-7 w-7">
                    <img id="mode-icon"
                            src="@if (auth()->user()?->email_verified_at)
                                    {{ auth()->user()->profile->is_darkmode ?
                                            env('AWS_APP_URL') . '/icons/brillo.png' :
                                            env('AWS_APP_URL') . '/icons/modo-nocturno.png'
                                    }}
                                @else
                                    {{ session('urlModeIcon') ?? env('AWS_APP_URL') . '/icons/brillo.png' }}
                                @endif"
                            alt="Change Theme Mode"
                    >
                </button>

                <div class="hidden right-0 px-6 py-4 sm:block">
                    @guest
                        <div class="w-80 flex justify-evenly p-3 text-center">
                            <a href="{{ route('login') }}"
                                class="btn-logreg hover:scale-105 hover:shadow-sm dark:hover:shadow-slate-500 hover:shadow-slate-400">
                                Log in
                            </a>
                            <a href="{{ route('register') }}"
                                class="btn-logreg hover:scale-105 hover:shadow-sm dark:hover:shadow-slate-500 hover:shadow-slate-400">
                                Register
                            </a>
                        </div>
                    @endguest
                </div>

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-jet-dropdown align="right" width="64">
                        <x-slot name="trigger">
                            @auth()
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button
                                        class="flex text-sm border-2 border-transparent rounded-full transition">
                                        <img class="hidden sm:block h-10 w-10 rounded-full object-cover"
                                            src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <span class="hidden sm:inline-flex rounded-md">
                                        <button type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                            {{ Auth::user()->name }}

                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </span>
                                @endif
                            @endauth

                        </x-slot>

                        <x-slot name="content">
                            @auth
                                <div class="pb-2">
                                    <!-- User Info -->
                                    <x-layout.dropdown-user-info />
                                </div>

                                <x-layout.dropdown-separator />

                                <div>
                                    <x-jet-dropdown-link href="{{ route('dashboard') }}">
                                        <x-layout.dropdown-icon srcPath="profile" />
                                        {{ __('Profile') }}
                                    </x-jet-dropdown-link>

                                    <x-jet-dropdown-link href="{{ route('dashboard') }}">
                                        <x-layout.dropdown-icon srcPath="statistics" />
                                        {{ __('Statistics') }}
                                    </x-jet-dropdown-link>

                                    <x-jet-dropdown-link href="{{ route('messenger.index') }}">
                                        <x-layout.dropdown-icon srcPath="messages" />
                                        {{ __('Messenger') }}
                                    </x-jet-dropdown-link>

                                    <x-layout.dropdown-separator />

                                    <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                        <x-layout.dropdown-icon srcPath="settings" />
                                        {{ __('Settings') }}
                                    </x-jet-dropdown-link>

                                    <x-jet-dropdown-link button="true" @click="idiom = !idiom" id="idioms" @click.away="idiom = false" @close.stop="idiom = false">
                                        <x-layout.dropdown-icon srcPath="idioms" />
                                        {{ __('Idiom') }}
                                    </x-jet-dropdown-link>
                                    <div id="idiom-list" :class="{ 'block': idiom, 'hidden': !idiom  }" class="flex justify-end overflow-hidden">
                                        <div class="w-2/3 p-1 flex flex-col">
                                            <a href="" class="dropdown-link__idiom">English</a>
                                            <a href="" class="dropdown-link__idiom">Spanish</a>
                                        </div>
                                    </div>

                                    <x-layout.dropdown-separator />

                                    <x-jet-dropdown-link :button="true" class="relative cursor-pointer">
                                        <div id="donate-button-container" class="absolute opacity-0">
                                            <div id="donate-button"></div>
                                            <script src="https://www.paypalobjects.com/donate/sdk/donate-sdk.js" charset="UTF-8"></script>
                                            <script>
                                            PayPal.Donation.Button({
                                            env:'production',
                                            hosted_button_id:'PYNR793FU65ES',
                                            image: {
                                            src:'https://www.paypalobjects.com/en_US/ES/i/btn/btn_donateCC_LG.gif',
                                            alt:'Donate with PayPal button',
                                            title:'PayPal - The safer, easier way to pay online!',
                                            }
                                            }).render('#donate-button');
                                            </script>
                                        </div>

                                        <x-layout.dropdown-icon srcPath="donate" />
                                        {{ __('Paypal Donate') }}
                                    </x-jet-dropdown-link>

                                    <x-jet-dropdown-link href="{{ route('help') }}">
                                        <x-layout.dropdown-icon srcPath="help" />
                                        {{ __('Help') }}
                                    </x-jet-dropdown-link>

                                    <x-jet-dropdown-link :button="true" x-on:click="$modals.show('send-report-modal')" class="cursor-pointer">
                                        <x-layout.dropdown-icon srcPath="send-reports" />
                                        {{ __('Send Reports') }}
                                    </x-jet-dropdown-link>

                                    <x-layout.dropdown-separator />

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf
                                        <x-jet-dropdown-link class="cursor-pointer" @click.prevent="$root.submit();">
                                            <x-layout.dropdown-icon srcPath="logout" />
                                            {{ __('Log Out') }}
                                        </x-jet-dropdown-link>
                                    </form>
                                </div>
                            @endauth
                        </x-slot>

                    </x-jet-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <x-layout.hub responsive />
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div
        :class="{ 'block': responsiveOpen, 'hidden': !responsiveOpen }"
        class="hidden sm:hidden"
        @resize.window="
            width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
            if (width > 640 && responsiveOpen) {
                responsiveOpen = false;
                transformHub(DOMelems.responsiveHub, responsiveOpen);
            }
        "
    >

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 max-h-[80vh] overflow-y-auto scrollbar-inner-menu">
            @auth()
                <div>
                    <!-- User Info -->
                    <x-layout.dropdown-user-info />
                </div>

                <x-layout.dropdown-separator />

                <div class="mt-3 space-y-1 p-2">

                    <div class="text-lg text-gray-700 dark:text-slate-200 p-1">Katawars Ways</div>
                    <x-jet-responsive-nav-link href="{{ route('dojo.index') }}">
                        {{ __('Dojo') }}
                    </x-jet-responsive-nav-link>

                    <x-layout.dropdown-separator />

                    <x-jet-responsive-nav-link href="{{ route('challenges.training') }}">
                        {{ __('Training') }}
                    </x-jet-responsive-nav-link>

                    <x-jet-responsive-nav-link href="{{ route('dashboard') }}">
                        {{ __('Blitz') }}
                    </x-jet-responsive-nav-link>

                    <x-jet-responsive-nav-link href="{{ route('dashboard') }}">
                        {{ __('Kata Ways') }}
                    </x-jet-responsive-nav-link>

                    <x-layout.dropdown-separator />

                    <x-jet-responsive-nav-link href="{{ route('mykatas.index') }}">
                        {{ __('My Katas') }}
                    </x-jet-responsive-nav-link>

                    <x-jet-responsive-nav-link href="{{ route('katas.saved') }}">
                        {{ __('Saved Katas') }}
                    </x-jet-responsive-nav-link>

                    <x-jet-responsive-nav-link href="{{ route('katas.favorites') }}">
                        {{ __('Favorites') }}
                    </x-jet-responsive-nav-link>

                    <x-layout.dropdown-separator />

                    <!-- Account Management -->
                    <div class="text-lg text-gray-700 dark:text-slate-200 p-1">Account Management</div>
                    <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Profile') }}
                    </x-jet-responsive-nav-link>

                    <x-jet-responsive-nav-link href="{{ route('dashboard') }}">
                        {{ __('Statistics') }}
                    </x-jet-responsive-nav-link>

                    <x-jet-responsive-nav-link href="{{ route('messenger.index') }}">
                        {{ __('Messenger') }}
                    </x-jet-responsive-nav-link>

                    <x-layout.dropdown-separator />

                    <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                        {{ __('Settings') }}
                    </x-jet-responsive-nav-link>

                    <x-jet-responsive-nav-link href="{{ route('help') }}">
                        {{ __('Help') }}
                    </x-jet-responsive-nav-link>

                    <x-layout.dropdown-separator />

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <x-jet-responsive-nav-link class="cursor-pointer" @click.prevent="$root.submit();">
                            {{ __('Log Out') }}
                        </x-jet-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="space-y-1 p-2">
                    <!-- Login -->
                    <x-jet-responsive-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                        {{ __('Log in') }}
                    </x-jet-responsive-nav-link>

                    <!-- Register -->
                    <x-jet-responsive-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')">
                        {{ __('Register') }}
                    </x-jet-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav>
