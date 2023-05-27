<x-app-layout>
    <x-layout.wrapped-main-section>
        @vite(['resources/js/favorites.js'])

        <main class="grid grid-cols-12 mt-8 gap-8">
            <div class="max-h-screen col-span-12 lg:col-span-4 sm:rounded-xl relative">

                <div class="h-full w-full border overflow-hidden border-blue-600 -z-10 absolute sm:rounded-xl">
                    <img class="w-full h-full saturate-150" src="{{ auth()->user()->profile_photo_url }}" alt="">
                </div>

                <div class="p-10 sm:border border-slate-400 sm:dark:border-cyan-600 shadow-xl sm:dark:shadow-outter-sm sm:dark:shadow-cyan-600 sm:rounded-xl bg-slate-200/70 dark:bg-slate-800/30 backdrop-blur-xl lg:min-h-screen">

                    <div class="text-slate-700 dark:text-slate-100">
                        <div class="text-4xl font-bold tracking-wider">
                            {{ __('Favorites') }}
                        </div>
                        <div class="pt-5 text-lg">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center">
                                <div class="overflow-hidden rounded-full pr-3">
                                    <img class="h-12 w-12 rounded-full" src="{{ auth()->user()->profile_photo_url }}" alt="">
                                </div>
                                <div>
                                    {{ auth()->user()->name }}
                                </div>
                            </a>
                        </div>
                        <div class="w-full pt text-sm pt-10 inline-flex justify-evenly items-center">
                            <span>
                                <span
                                    @updatefavorite.window="
                                        $el.textContent = $event.detail;
                                    "
                                >{{ $totalFavorites }}</span> Favorites</span>
                            <span>Updated {{ $lastUpdated ?? 'never' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-8 py-2" x-ref="challenges">
                @if ($favorites->count())
                <div id="list" class="lista" x-ref="list">
                    <x-layout.order-button routeAsc="{{ route('katas.favorites') }}" routeDesc="{{ route('katas.favorites') }}" />
                        @foreach ($favorites as $favorite)

                            @php
                                $challenge = $favorite->solution->kata->challenge;
                            @endphp

                            <div class="card-challenge grid grid-cols-12" id="{{ $challenge->id }}">

                                <aside class="flex justify-start items-center cols-span-1 transition-all duration-500 overflow-hidden">
                                    <div class="hubgrab"></div>
                                </aside>

                                <div class="col-span-11 relative">
                                    <div class="w-full flex flex-row justify-between">
                                        <div class="w-full flex flex-row justify-start items-center">
                                            @foreach ($challenge->categories as $category )
                                                <a href="{{ route('challenges.training') }}?category={{$category->name}}">
                                                    <div class="bg-slate-50 dark:bg-slate-900 border border-slate-400 dark:border-slate-800 shadow-md hover:bg-violet-600 dark:hover:bg-violet-600 hover:text-slate-100 cursor-pointer px-2 rounded-lg mr-2">
                                                        <span class="category">{{ $category->name }}</span>
                                                    </div>
                                                </a>
                                            @endforeach
                                            <x-utilities.rank size="4" :rank="$challenge->rank->name" />
                                        </div>
                                    </div>

                                    <div class="py-2">
                                        <a href="{{ $challenge->url }}" class="">
                                            <div class="text-center text-ellipsis-1 text-xl text-violet-600 dark:text-tomato">
                                                {{ $challenge->title }}
                                            </div>
                                            <div class="text-ellipsis-3">
                                                <span>
                                                    {!! $challenge->description !!}
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                    <div id="{{ $challenge->id }}" class="cross-savedkata">
                                        <div class="cross">
                                            &times;
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                @else
                    <h1 class="flex items-center text-lg dark:text-slate-100 font-semibold justify-center">Your list its empty.</h1>
                @endif
            </div>
        </main>
    </x-layout.wrapped-main-section>
</x-app-layout>
