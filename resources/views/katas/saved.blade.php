<x-app-layout>
    <x-layout.wrapped-main-section>
        @vite(['resources/js/savedkatas.js'])

        <main class="grid grid-cols-12 mt-8 gap-8">
            <div class="max-h-screen col-span-12 lg:col-span-4 sm:rounded-xl relative">

                <div class="h-full w-full border overflow-hidden border-blue-600 -z-10 absolute sm:rounded-xl">
                    <img class="w-full h-full saturate-150" src="{{ auth()->user()->profile_photo_url }}" alt="">
                </div>

                <div class="p-10 sm:border border-slate-400 sm:dark:border-cyan-600 shadow-xl sm:dark:shadow-outter-sm sm:dark:shadow-cyan-600 sm:rounded-xl bg-slate-200/70 dark:bg-slate-800/30 backdrop-blur-xl lg:min-h-screen">

                    <div class="text-slate-700 dark:text-slate-100">
                        <div class="text-4xl font-bold tracking-wider">
                            {{ __('Saved Katas') }}
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
                            <span>{{ $totalSavedKatas }} Saved Katas</span>
                            <span>Updated {{ $lastUpdated ?? 'never' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-8 py-2" x-ref="challenges">

                <div class="pb-8">
                    <x-jet-dropdown align="left" width="64">
                        <x-slot name="trigger">
                            <div
                                class="w-fit p-2 cursor-pointer active:scale-90 hover:bg-slate-200/70 dark:hover:bg-slate-800/50 rounded-full transform transition-all duration-100"
                                :class="{'shadow-lg bg-slate-200/70 dark:bg-slate-800/50': open, 'bg-transparent': !open}"
                            >
                                <img class="hidden sm:block h-8 w-8 rounded-full object-cover" src="https://s3.eu-south-2.amazonaws.com/katawars.es/app/icons/hub-menu1.png" alt="">
                            </div>
                        </x-slot>

                        <x-slot name="content">
                            <div>
                                <x-jet-dropdown-link
                                    :button="true"
                                    class="cursor-pointer"
                                    @click="alert('asc')"
                                >
                                    {{ __('Ascending (from less to more)') }}
                                </x-jet-dropdown-link>

                                <x-jet-dropdown-link
                                    :button="true"
                                    class="cursor-pointer"
                                    @click="alert('desc')"
                                >
                                    {{ __('Descending (from more to less)') }}
                                </x-jet-dropdown-link>
                            </div>
                        </x-slot>
                    </x-jet-dropdown>
                </div>

                @if ($savedKatas->count())
                    <div id="list" class="lista">
                        @foreach ($savedKatas as $savedKata)
                            <div class="card-challenge grid grid-cols-12" id="{{ $savedKata->id }}">

                                <aside class="handle cursor-grab flex justify-start items-center cols-span-1 transition-all duration-500 overflow-hidden">
                                    <div class="hubgrab">
                                        <div class="bar bg-slate-500/70 dark:bg-slate-500/70 transition-all duration-300"></div>
                                        <div class="bar bg-slate-500/70 dark:bg-slate-500/70 transition-all duration-300"></div>
                                    </div>
                                </aside>

                                <div class="col-span-11">
                                    <div class="w-full flex flex-row justify-between">
                                        <div class="w-full flex flex-row justify-start items-center">
                                            @foreach ($savedKata->challenge->categories as $category )
                                                <a href="{{ route('challenges.training') }}?category={{$category->name}}">
                                                    <div class="bg-slate-50 dark:bg-slate-900 border border-slate-400 dark:border-slate-800 shadow-md hover:bg-violet-600 dark:hover:bg-violet-600 hover:text-slate-100 cursor-pointer px-2 rounded-lg mr-2">
                                                        <span class="category">{{ $category->name }}</span>
                                                    </div>
                                                </a>

                                            @endforeach
                                            <x-utilities.rank size="4" :rank="$savedKata->challenge->rank->name" />
                                        </div>
                                    </div>

                                    <div class="py-2">
                                        <a href="{{ $savedKata->challenge->url }}" class="">
                                            <div class="text-center text-ellipsis-1 text-xl text-violet-600 dark:text-tomato">
                                                {{ $savedKata->challenge->title }}
                                            </div>
                                            <div class="text-ellipsis-3">
                                                <span>
                                                    {!! $savedKata->challenge->description !!}
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div id="next-cursor" class="hidden">
                            {{ $nextCursor }}
                        </div>
                    </div>
                @else
                    <h1 class="flex items-center text-lg dark:text-slate-100 font-semibold justify-center">Your list its empty.</h1>
                @endif
            </div>
        </main>

    </x-layout.wrapped-main-section>
</x-app-layout>
