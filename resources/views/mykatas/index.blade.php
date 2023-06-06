<x-app-layout>
    <x-layout.wrapped-main-section>

        <main class="grid grid-cols-12 mt-8 gap-8">
            <div class="max-h-screen col-span-12 lg:col-span-4 sm:rounded-xl relative">

                <div class="h-full w-full border overflow-hidden border-blue-600 -z-10 absolute sm:rounded-xl">
                    <img class="w-full h-full saturate-150" src="{{ auth()->user()->profile_photo_url }}" alt="">
                </div>

                <div class="p-10 sm:border border-slate-400 sm:dark:border-cyan-600 shadow-xl sm:dark:shadow-outter-sm sm:dark:shadow-cyan-600 sm:rounded-xl bg-slate-200/70 dark:bg-slate-800/30 backdrop-blur-xl lg:min-h-screen">

                    <div class="text-slate-700 dark:text-slate-100">
                        <div class="text-4xl font-bold tracking-wider">
                            {{ __('My Katas') }}
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
                                    @updatefavorites.window="
                                        $el.textContent = $event.detail;
                                    "
                                >{{ $totalKatas }}</span> Katas Created</span>
                            <span>Updated {{ $lastUpdated ?? 'never' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            @if ($isAllowed)

                <div class="col-span-12 lg:col-span-8 py-2" x-ref="challenges">
                    <div class="flex justify-end">
                        <x-layout.button-link :button="false" href="{{ route('mykatas.create') }}">
                            {{ __('Create') }}
                        </x-layout.button-link>
                    </div>
                    @if ($totalKatas)
                        <x-layout.order-button-sync route="{{ route('mykatas.index') }}" />
                        <div id="list" class="lista" x-ref="list">

                            @foreach ($mykatas as $mykata)

                                @php
                                    $challenge = $mykata->challenge;
                                @endphp

                                <div class="card-challenge grid grid-cols-12" id="{{ $challenge->id }}">

                                    <aside class="flex justify-start items-center cols-span-1 transition-all duration-500 overflow-hidden">
                                        <div class="hubgrab"></div>
                                    </aside>

                                    <div class="col-span-11 relative">
                                        <div class="w-full flex flex-row justify-between">
                                            <div class="w-full flex flex-row justify-start items-center">
                                                @foreach ($challenge->categories as $category )
                                                    @php

                                                        $selectedCategory = request()->query('category') ?? '';
                                                        $isSelected = request()->query('selected') === 'true' && $selectedCategory === $category->name;
                                                    @endphp
                                                    <a href="{{ route('mykatas.index') }}?category={{$category->name}}&ord={{ request()->query('ord') }}&selected={{ request()->query('selected') == 'true' ? '' : 'true' }}">
                                                        <div class="bg-slate-50 dark:bg-slate-900 @if($isSelected) bg-violet-600 dark:bg-violet-600 text-slate-100  @endif border border-slate-400 dark:border-slate-800 shadow-md hover:bg-violet-600 dark:hover:bg-violet-600 hover:text-slate-100 cursor-pointer px-2 rounded-lg mr-2">
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
                            <div id="next-cursor" class="hidden">
                                {{ $nextCursor }}
                            </div>
                        </div>
                    @else
                        <h1 class="flex items-center text-lg dark:text-slate-100 font-semibold justify-center">Your list its empty.</h1>
                    @endif
                </div>

            @else

                <div class="col-span-12 lg:col-span-8 py-2 min-h-screen flex justify-center items-center flex-col">
                    <div class="w-full md:w-[80%]">
                        <h1 class="flex items-center text-lg dark:text-slate-100 font-semibold justify-center">
                            {{ __('Section Blocked only for Black Ranked User.') }}
                        </h1>
                        <h1 class="flex items-center text-lg dark:text-slate-100 font-semibold justify-center">
                            {{ __('Coding hard and return early as you obtain the necessary ranked!') }}
                        </h1>
                    </div>

                </div>

            @endif
        </main>

        <script>
                        // Set sortable object with the list of saved katas.
            const list = document.getElementById('list');

                if (list) {

                    // Async Infinite Scroll

                    window.addEventListener('DOMContentLoaded', (eDCL) => {
                        window.addEventListener('scroll', (eScroll) => {
                            eScroll.stopImmediatePropagation();

                            if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {

                                let url = window.location.href;
                                let nextCursor = document.querySelector('#next-cursor').innerHTML || null;

                                if (nextCursor) {
                                    axios({
                                        method: 'get',
                                        url: url,
                                        responseType: 'json',
                                        params: {
                                            nextCursor: nextCursor.trim(),
                                        },
                                    })
                                    .then(response => {
                                        if (response.data.success) {
                                            console.log(response.data.nextCursor);
                                            list.insertAdjacentHTML('beforeend', response.data.html);
                                            list.querySelector('#next-cursor').innerHTML = response.data.nextCursor;
                                        } else {
                                            console.log(response.data.nextCursor); // PENDIENTE ELIMINAR
                                        }
                                    })
                                    .catch(error => console.log(error));
                                }
                            }
                        })
                    });
                }
        </script>
    </x-layout.wrapped-main-section>
</x-app-layout>
