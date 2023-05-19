<x-app-layout>
    <div class="min-h-screen py-12">
        <div class="max-w-7xl mx-auto md:px-6 lg:px-8">
            <div class="sm:rounded-lg">

                <header class="md:py-6 w-full sm:card-panel">

                    <div class="grid grid-flow-row md:grid-flow-col md:grid-cols-12 gap-4">

                        <div class="p-5 grid col-span-12 md:col-span-6 justify-items-center gap-6">

                            <div
                                class="w-44 h-44 rounded-full shadow-2xl shadow-violet-600 dark:shadow-cyan-600v"
                            >
                                <a href="{{ auth()->user()->id == $userValues['id'] ? route('profile.show') : '' }}">
                                    <img class="w-full h-full rounded-full block hover:scale-110 transition-all duration-500" src="{{ $userValues['avatar'] }}" alt="Profile Photo">
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

                                <div class="grid grid-flow-col grid-cols-7 gap-8 min-h-full py-2">

                                    <div class="grid col-span-4 items-center border-r border-r-gray-300 dark:border-r-slate-500 dark:text-slate-200">

                                        <div>
                                            <label class="pr-1 font-bold">Ranked:</label>
                                            <span class="">#{{ $userValues['ranking'] }}</p>
                                        </div>

                                        <div class="">
                                            <label class="pr-1 font-bold">Rank:</label>
                                            <span class="text-md">
                                                {{ __(ucfirst($userValues['rank'])) }}
                                            </span>
                                            <x-utilities.rank :rank="$userValues['rank']"/>
                                        </div>

                                        <div>
                                            <label class="pr-1 font-bold">Member Since:</label>
                                            <span class="">{{ $userValues['time_elapsed'] }}</span>
                                        </div>

                                        <div>
                                            <label class="pr-1 font-bold">Last Connection:</label>
                                            <span class="">
                                                {{ $userValues['last_activity'] }}
                                            </span>
                                        </div>

                                    </div>


                                    <div class="grid col-span-3 dark:text-slate-200">
                                        <div class="flex flex-col justify-evenly">

                                            <p><span class="font-bold">{{ number_format($userValues['exp']) }}</span><span class="pl-1">EXP</span></p>
                                            <p><span class="font-bold">{{ number_format($userValues['honor']) }}</span><span class="pl-1">HONOR</span></p>
                                        </div>

                                    </div>

                                </div>

                                <x-layout.progress-bar size="4" title="Rank Progress" />

                            </div>

                        </div>
                    </div>
                </header>

                <main x-data="{stats: true, katas: false, kataways: false, created: false}" class="sm:mt-8 grid grid-flow-row sm:card-panel">
                    <nav class="grid grid-flow-col grid-cols-12 shadow-xl relative overflow-hidden dark:text-slate-200">

                        <div
                            class="tab col-span-3"
                            :class="{'dark:text-slate-50 text-slate-700 tracking-wider': stats}"
                            x-on:click="stats = true, katas = false, kataways = false, created = false"
                        >
                            <span class="">Statistics</span>
                            <div class="tab-bottom" :class="{'tab-selected': stats}"></div>
                        </div>

                        <div
                            class="tab col-span-3"
                            :class="{'dark:text-slate-50 text-slate-700 tracking-wider': katas}"
                            x-on:click="stats = false, katas = true, kataways = false, created = false"
                        >
                            <span class="">Passed Katas</span>
                            <div class="tab-bottom" :class="{'tab-selected': katas}"></div>
                        </div>

                        <div
                            class="tab col-span-3"
                            :class="{'dark:text-slate-50 text-slate-700 tracking-wider': kataways}"
                            x-on:click="stats = false, katas = false, kataways = true, created = false"
                        >
                            <span class="">Kataways</span>
                            <div class="tab-bottom" :class="{'tab-selected': kataways}"></div>
                        </div>

                        <div
                            class="tab col-span-3"
                            :class="{'dark:text-slate-50 text-slate-700 tracking-wider': created}"
                            x-on:click="stats = false, katas = false, kataways = false, created = true"
                        >
                            <span class="">Created Katas</span>
                            <div class="tab-bottom" :class="{'tab-selected': created}"></div>
                        </div>

                    </nav>
                    <div class="min-h-screen grid grid-flow-row">
                        <div class="py-5">
                            <section x-show="stats" style="display: none;">
                                Statistics
                            </section>
                            <section x-show="katas"style="display: none;">
                                Passed Katas
                            </section>
                            <section x-show="kataways" style="display: none;">
                                Kataways
                            </section>
                            <section x-show="created" style="display: none;">
                                Created
                            </section>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</x-app-layout>
