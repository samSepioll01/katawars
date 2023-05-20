<x-app-layout>
    <x-layout.wrapped-main-section>
        <main x-data="{instructions: true, code: false, resources: false, solutions: false}" class="sm:mt-8 grid grid-flow-row sm:card-panel">
            <nav class="grid grid-flow-col grid-cols-12 shadow-xl relative overflow-hidden dark:text-slate-200">

                <div
                    class="tab col-span-3"
                    :class="{'dark:text-slate-50 text-slate-700 tracking-wider': instructions}"
                    x-on:click="instructions = true, code = false, resources = false, solutions = false"
                >
                    <span class="">Instructions</span>
                    <div class="tab-bottom" :class="{'tab-selected': instructions}"></div>
                </div>

                <div
                    class="tab col-span-3"
                    :class="{'dark:text-slate-50 text-slate-700 tracking-wider': code}"
                    x-on:click="instructions = false, code = true, resources = false, solutions = false"
                >
                    <span class="">Code</span>
                    <div class="tab-bottom" :class="{'tab-selected': code}"></div>
                </div>

                <div
                    class="tab col-span-3"
                    :class="{'dark:text-slate-50 text-slate-700 tracking-wider': resources}"
                    x-on:click="instructions = false, code = false, resources = true, solutions = false"
                >
                    <span class="">Resources</span>
                    <div class="tab-bottom" :class="{'tab-selected': resources}"></div>
                </div>

                <div
                    class="tab col-span-3"
                    :class="{'dark:text-slate-50 text-slate-700 tracking-wider': solutions}"
                    x-on:click="instructions = false, code = false, resources = false, solutions = true"
                >
                    <span class="">Solutions</span>
                    <div class="tab-bottom" :class="{'tab-selected': solutions}"></div>
                </div>

            </nav>
            <div class="min-h-screen grid grid-flow-row">
                <div class="py-5">
                    <section x-show="instructions" style="display: none;">
                        <div class="dark:text-slate-100 p-10">
                            <div>
                                <h1 class="text-3xl text-bold">
                                    {{ $challenge->title }}
                                </h1>
                                <h3 class="flex flex-row items-center text-sm py-2">
                                    <span>Published by</span>
                                    <a href="{{ $owner->profile->url }}" class="flex flex-row pl-2 items-center">
                                        <span>
                                            <img src="{{ $owner->profile_photo_url }}" class="h-8 w-8 rounded-full" alt="">
                                        </span>
                                        <span class="pl-2 text-lg">
                                            {{ $owner->name }}
                                        </span>
                                    </a>
                                </h3>
                            </div>
                            <div class="py-2 flex flex-row justify-start items-center">
                                @foreach ($challenge->categories as $category)
                                    <div class="bg-violet-600 dark:bg-slate-900 border border-slate-400 dark:border-slate-800 shadow-md text-slate-100 px-2 rounded-lg mr-2 cursor-pointer"
                                         x-on:click="window.location.href = window.location.origin + '/training'"
                                    >
                                        {{ $category->name }}
                                    </div>
                                @endforeach
                            </div>
                            <div class="py-3">{!! $challenge->description !!}</div>
                            <div class="py-3">
                                <h3 class="font-bold text-lg py-3">Examples</h3>
                                <div class="p-5 bg-slate-100 dark:bg-slate-800/70 border-2 border-l-violet-600 dark:border-l-cyan-600 border-transparent rounded-r-md">
                                    {!! $challenge->examples !!}
                                </div>

                            </div>
                            <div class="mt-8 p-5 bg-slate-100 dark:bg-slate-800/70 border border-slate-200 dark:border-slate-800 rounded-md">
                                {!! $challenge->notes !!}
                            </div>
                        </div>
                    </section>
                    <section x-show="code"style="display: none;">
                        Code
                    </section>
                    <section x-show="resources" style="display: none;">
                        Resources
                    </section>
                    <section x-show="solutions" style="display: none;">
                        Solutions
                    </section>
                </div>
            </div>
        </main>
    </x-layout.wrapped-main-section>
</x-app-layout>



