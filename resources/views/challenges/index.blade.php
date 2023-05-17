<x-app-layout>
    <x-layout.wrapped-main-section>

        <header class="">
            <div id="searcher" class="h-8 rounded-l-full rounded-r-full flex justify-center card-panel">
                Buscador
            </div>
        </header>

        <main class="grid grid-cols-12 mt-8">
            <div class="grid col-span-12 sm:col-span-3">
                panel filtrado
            </div>
            <div class="grid col-span-12 sm:col-span-9 py-2" x-ref="challenges">
                @foreach ($challenges as $challenge)
                    <div class="card-challenge">

                        <div class="w-full flex flex-row justify-between">

                            <div class="w-full flex flex-row justify-start items-center">
                                @foreach ($challenge->categories as $category )
                                    <div class="bg-slate-50 dark:bg-slate-900 border border-slate-400 dark:border-slate-800 shadow-md hover:bg-violet-600 dark:hover:bg-violet-600 hover:text-slate-100 cursor-pointer px-2 rounded-lg mr-2">

                                        <span class="category"
                                              x-on:click="
                                                axios({
                                                    method: 'get',
                                                    url: '/training/{{ $category->name }}',
                                                    responseType: 'json',
                                                })
                                                .then(response => response.data.success
                                                    ? $refs.challenges.innerHTML = response.data.challenges
                                                    : null
                                                )
                                                .catch(error => console.log(error));
                                              "
                                        >
                                            {{ $category->name }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                            <div>
                                favorite
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

                    </div>
                @endforeach
            </div>
        </main>

    </x-layout.wrapped-main-section>
</x-app-layout>
