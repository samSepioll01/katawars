<x-app-layout>
    {{-- <style>
        div {
            padding: 5px;
            border: 1px solid crimson;
        }
    </style> --}}

    <div class="min-h-screen py-12">
        <div class="max-w-7xl mx-auto md:px-6 lg:px-8 bg-white dark:bg-[rgb(31,31,31)]/30 border border-slate-800/20 rounded-md shadow-xl">
            <div class="overflow-hidden sm:rounded-lg">

                <header class="md:py-6 w-full">

                    <div class="grid grid-flow-row md:grid-flow-col md:grid-cols-12 gap-4">

                        <div class="p-5 grid col-span-12 md:col-span-6 justify-items-center gap-6">

                            <div class="w-44 h-44 rounded-full shadow-2xl shadow-violet-600 dark:shadow-cyan-600 @unless($userValues['rank'] === 'white') ring-8 ring-{{ $userValues['rank'] }}-600 @endunless">
                                <a href="{{ route('profile.show') }}">
                                    <img class="rounded-full block hover:scale-110 transition-all duration-500" src="{{ auth()->user()->profile_photo_url }}" alt="Profile Photo">
                                </a>
                            </div>

                            <div class="text-xl text-gray-600 dark:text-slate-200">
                                {{ __($userValues['nickname']) }}
                            </div>

                            <div class="w-full flex justify-evenly text-sm dark:text-slate-200">

                                <a href="" class="hover:text-violet-600 trasition-colors duration-300">
                                    <span class="font-bold">{{ $userValues['count_followers'] }}</span>
                                    <span class="pl-1 tracking-wide">Followers</span>
                                </a>
                                <a href="" class="hover:text-violet-600 trasition-colors duration-300">
                                    <span class="font-bold">{{ $userValues['count_following'] }}</span>
                                    <span class="pl-1 tracking-wide">Following</span>
                                </a>

                            </div>

                            <div class="w-full dark:text-slate-200">
                                {{ __($userValues['bio']) }}
                            </div>

                        </div>

                        <div class="grid col-span-12 lg:col-span-6">

                            <div class="w-full grid grid-flow-row grid-row-2 p-5">

                                <div class="grid grid-flow-col grid-cols-6 gap-8 min-h-full py-2">

                                    <div class="grid col-span-4 items-center border-r border-r-gray-300 dark:border-r-slate-500 dark:text-slate-200">

                                        <div class="">
                                            <label class="pr-1 font-bold">Rank:</label>
                                            <span class="text-md">
                                                {{ __(ucfirst($userValues['rank'])) }}
                                            </span>
                                            <div
                                                class="w-6 h-6 inline-flex
                                                        @if( $userValues['rank'] === 'white' || $userValues['rank'] === 'black' )
                                                            bg-{{$userValues['rank']}}
                                                        @else
                                                            bg-{{$userValues['rank']}}-600
                                                        @endif
                                                        rounded-full border border-slate-500 shadow-outter-sm shadow-slate-600
                                                "
                                            ></div>
                                        </div>

                                        <div>
                                            <label class="pr-1 font-bold">Member Since:</label>
                                            <span class="">{{ $userValues['time_elapsed'] }}</span>
                                        </div>

                                        <div>
                                            <label class="pr-1 font-bold">Status Connection:</label>
                                            <span class="">{{ $userValues['last_activity']->diffInMinutes() <= 1 ? 'Online' : $userValues['last_activity']->diffForHumans(now())  }}</p>
                                        </div>

                                    </div>


                                    <div class="grid col-span-2 dark:text-slate-200">
                                        <div class="flex flex-col justify-evenly">
                                            <p><span class="font-bold">{{ $userValues['exp'] }}</span><span class="pl-1">EXP</span></p>
                                            <p><span class="font-bold">{{ $userValues['honor'] }}</span><span class="pl-1">HONOR</span></p>
                                        </div>

                                    </div>

                                </div>

                                <x-layout.progress-bar size="4" title="Rank Progress" :progress="$userValues['exp2next']" />

                            </div>

                        </div>
                    </div>
                </header>

                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            <div class="ml-4 text-lg text-gray-600 dark:text-slate-100 leading-7 font-semibold"><a href="https://laravel.com/docs">Documentation</a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                                Laravel has wonderful documentation covering every aspect of the framework. Whether you're new to the framework or have previous experience, we recommend reading all of the documentation from beginning to end.
                            </div>

                            <a href="https://laravel.com/docs">
                                <div class="mt-3 flex items-center text-sm font-semibold text-fuchsia-600">
                                        <div>Explore the documentation</div>

                                        <div class="ml-1 text-indigo-500">
                                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <div class="ml-4 text-lg text-gray-600 dark:text-slate-100 leading-7 font-semibold"><a href="https://laracasts.com">Laracasts</a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                                Laracasts offers thousands of video tutorials on Laravel, PHP, and JavaScript development. Check them out, see for yourself, and massively level up your development skills in the process.
                            </div>

                            <a href="https://laracasts.com">
                                <div class="mt-3 flex items-center text-sm font-semibold text-fuchsia-600">
                                        <div>Start watching Laracasts</div>

                                        <div class="ml-1 text-indigo-500">
                                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200">
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <div class="ml-4 text-lg text-gray-600 dark:text-slate-100 leading-7 font-semibold"><a href="https://tailwindcss.com/">Tailwind</a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                                Laravel Jetstream is built with Tailwind, an amazing utility first CSS framework that doesn't get in your way. You'll be amazed how easily you can build and maintain fresh, modern designs with this wonderful framework at your fingertips.
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 md:border-l">
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            <div class="ml-4 text-lg text-gray-600 dark:text-slate-100 leading-7 font-semibold">Authentication</div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                                Authentication and registration views are included with Laravel Jetstream, as well as support for user email verification and resetting forgotten passwords. So, you're free to get started what matters most: building your application.
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
