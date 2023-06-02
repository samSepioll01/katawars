<x-app-layout>
    <x-layout.wrapped-main-section>
        <div id="cont_btn" class="w-full flex flex-row justify-between items-center p-2">
            <form action="{{ route('katas.change', ['id' => $previous]) }}" method="get">
                <x-jet-button class="w-32 flex justify-center">Previous</x-jet-button>
            </form>

            <form action="{{ route('katas.change', ['id' => $next]) }}" method="get">
                <x-jet-button id="next_btn" class="w-32 flex justify-center">Next</x-jet-button>
            </form>
        </div>
        <main
            x-data="{instructions: {{ session('tabinstructions') ?? 'true' }}, code: false, resources: {{ session('tabresources') ?? 'false' }}, solutions: {{ session('tabsolutions') ?? 'false' }}}"
            class="sm:mt-8 grid grid-flow-row sm:card-panel"
        >
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
                                <div class="flex flex-row justify-between items-center">
                                    <h1 class="text-3xl text-bold">
                                        {{ $challenge->title }}
                                    </h1>
                                    <div class="flex flex-row justify-between items-center w-36">
                                        <x-layout.saved-marker :id="$challenge->katas->first()->id"/>
                                        <div class="px-5"></div>

                                        @if (auth()->user()->profile->passedKatas()->get()->contains($challenge->katas->first()->id))
                                            <x-layout.favorite-button :id="$challenge->katas->first()->id" size="lg" />
                                        @endif

                                    </div>
                                </div>

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
                                         x-on:click="window.location.href = window.location.origin + '/training?category={{$category->name}}'"
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
                    <section x-show="code" style="display: none;">
                        <div
                            class="grid grid-cols-12 gap-8 md:px-20 py-10 opacity-0 transition-all duration-300"
                            x-init="setTimeout(() => $el.classList.add('opacity-100'), 300)"
                        >
                            <div class="h-96 col-span-12 lg:col-span-8 relative">
                                <div
                                    id="editor"
                                    class="editorkata"
                                    @changetheme.window="
                                        if ($event.detail === 'light') {
                                            ace.edit('editor').setTheme('ace/theme/solarized_light');
                                        }

                                        if ($event.detail === 'dark') {
                                            ace.edit('editor').setTheme('ace/theme/monokai');
                                        }
                                    "
                                >&lt;?php&#10;{!!$signature!!}&#10;&#9;return '';&#10;}</div>
                                <x-jet-button x-ref="check" id="check" class="absolute right-0 bottom-0">Check</x-jet-button>
                            </div>
                            <div class="errorkata">
                                <div class="w-full text-slate-700 dark:text-slate-200">
                                    <div id="error-panel" class="w-full h-96 overflow-y-auto scrollbar-inner-menu p-3 break-words">
                                        <div id="tip" class="w-full h-full flex flex-col justify-center items-center">
                                            <h1 class="text-2xl font-bold text-violet-600 dark:text-tomato">Pro Tip</h1>
                                            <h3 class="py-2">Press <i>Cntrl + Space</i> to <i>Check Code</i>.</h3>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </section>
                    <section x-show="resources" style="display: none;">
                        <div class="w-full flex justify-end">
                            <div class="pr-12">
                                <x-jet-button class="" x-on:click="
                                    $modals.show('create-resource-modal');
                                ">
                                    Add
                                </x-jet-button>
                            </div>

                        </div>
                        <div class="w-full px-10 py-5 flex justify-center">

                            <div class="w-3/4">

                                @if ($resources->count())
                                    @foreach ($resources as $resource)
                                        <div class="card-challenge relative">

                                            <div class="w-full flex flex-row justify-between">

                                                <div class=" w-full flex flex-row justify-end gap-8 item-center">
                                                    @livewire('like-button', ['model' => $resource])
                                                </div>

                                            </div>

                                            <div class="py-2">
                                                <a href="{{ $resource->url }}" target="_blank" class="">
                                                    <div class="text-center text-ellipsis-1 text-xl text-violet-600 dark:text-tomato">
                                                        {{ $resource->title }}
                                                    </div>
                                                    <div class="text-sm text-center">
                                                        {{ $resource->url }}
                                                    </div>
                                                    <div class="text-ellipsis-3 py-1">
                                                        <span>
                                                            {!! $resource->description !!}
                                                        </span>
                                                    </div>
                                                    <div class="absolute left-3 top-1 text-xs">
                                                        Published <span> {{ $resource->created_at->diffForHumans(now()) }} </span>
                                                    </div>
                                                </a>
                                            </div>

                                            @if (auth()->user()->profile->id === $resource->profile_id || auth()->user()->hasRole(['admin', 'superadmin']))
                                                <div class="absolute bottom-1 right-3">
                                                    <x-jet-button x-on:click="
                                                        axios({
                                                            method: 'get',
                                                            url: location.origin + '/katas/{{$challenge->slug}}/get-resource/' + {{$resource->id}},
                                                            responseType: 'json',
                                                        })
                                                        .then(response => {
                                                            if (response.data.success) {
                                                                document.getElementById('edit-title').value = response.data.title;
                                                                document.getElementById('edit-url').value = response.data.url;
                                                                document.getElementById('edit-description').textContent = response.data.description;
                                                                document.getElementById('edit-form').action = response.data.action;
                                                            }
                                                        })
                                                        .catch(errors => console.log(erros));
                                                        $modals.show('edit-resource-modal');
                                                    ">Edit</x-jet-button>
                                                </div>
                                            @endif

                                        </div>
                                    @endforeach

                                @else
                                        <div class="w-full h-3/4 flex justify-center items-center">
                                            <h1 class="text-slate-700/70 dark:text-slate-100 font-bold text-xl">Be the first in publish a resource.</h1>
                                        </div>

                                @endif

                            </div>
                        </div>
                    </section>

                    @vite(['resources/css/prism.css', 'resources/js/prism.js'])

                    <section id="cont-solutions" x-show="solutions" style="display: none;">

                        @if ($isPassedKata || $isSkippedKata)

                            @if ($challenge->katas->first()->video()->exists())
                                <div class="w-full flex justify-center">
                                    {!! $challenge->katas->first()->video->youtube_code !!}
                                </div>
                            @endif

                            <div class="w-full flex flex-col items-center gap-8 pt-5 justify-center">
                                @if ($solutions->count())
                                    @foreach ($solutions as $solution)
                                        <div class="w-full md:w-3/4 xl:w-1/2 relative">
                                            <a href="{{ $solution->profile->url }}">
                                                <div class="flex flex-row items-center">
                                                    <div class="py-2 px-3">
                                                        <img class="h-10 w-10 rounded-full" src="{{ $solution->profile->user->profile_photo_url }}" alt="">
                                                    </div>
                                                    <div class="text-slate-700 dark:text-slate-100 text-sm flex flex-col items-center">
                                                        <div>
                                                            {{ $solution->profile->user->name }}
                                                        </div>
                                                        <div class="text-[11px]">
                                                            {{ $solution->created_at->diffForHumans(now()) }}
                                                        </div>

                                                    </div>

                                                </div>
                                            </a>

                                            <div class="overflow-hidden rounded-lg">
                                                <pre class="rounded-md"><code class="language-javascript">{{ trim($solution->code) }}</code></pre>
                                            </div>
                                            <div class="w-full flex flex-row justify-between">
                                                <div class=" w-full flex flex-row justify-end gap-8 item-center">
                                                    @livewire('like-button', ['model' => $solution])
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <h1 class="text-slate-700/70 dark:text-slate-100 font-bold text-xl">Anybody completed this kata yet.</h1>
                                @endif
                            </div>


                        @else

                                <div class="w-full py-40">
                                    <div class="flex flex-col items-center justify-center">

                                        <div class="flex flex-row justify-center text-xl text-violet-600 dark:text-tomato">
                                            <span class="px-1">
                                                Click
                                            </span>
                                            <form action="{{ route('katas.unlock-solutions', ['slug' => $challenge->slug]) }}" method="get" class="px-1 hover:underline cursor-pointer transition-all duration-300 active:scale-95">
                                                <button type="submit">HERE</button>
                                            </form>
                                            <span class="px-1">
                                                to unlock Challenge.
                                            </span>
                                        </div>
                                        <div x-ref="unlockmessage" class="text-lg text-slate-700 dark:text-slate-100">
                                            Cuation! If you not complete this challenge you can't win EXP points.
                                        </div>

                                    </div>
                                </div>

                        @endif

                    </section>
                </div>
            </div>

            <x-layout.modal name="passedkata-modal" maxWidth="2xl">
                <x-slot name="title">
                    <div class="text-3xl text-center text-violet-600 dark:text-tomato tracking-wider">
                        {{ __('Congratulations!!!') }}
                    </div>
                    <div class="py-4 text-center">
                        Challenge Complete!!
                    </div>
                    <div class="cross-menu" @click.prevent="show = false">
                        &times;
                    </div>
                </x-slot>

                <x-slot name="body">
                    @if ($isPassedKata || $isSkippedKata)
                        <div class="w-full p-10 text-center text-slate-900">
                            <span class="text-2xl dark:text-slate-100">You passed o skipped this Challenge Previously.</span>
                        </div>
                    @else
                        <div class="w-full p-10 text-center text-slate-900">
                            <span class="text-6xl text-slate-100">{{ $score }}</span><span class="text-slate-100 text-4xl px-2">EXP</span>
                        </div>
                        <div class="w-full flex flex-row justify-center items-center p-10">
                            <div class="w-11/12">
                                <x-layout.progress-bar :sidebar="true" size="5" title="" />
                            </div>
                        </div>
                    @endif
                </x-slot>

                <x-slot name="footer">
                    <x-layout.favorite-button :id="$challenge->katas->first()->id" size="xl"/>
                        <div class="px-5"></div>
                    <form action="{{ route('katas.next-available') }}" method="get">
                        <x-jet-button>
                            Next Challenge
                        </x-jet-button>
                    </form>
                </x-slot>
            </x-layout.modal>

            <x-layout.modal name="create-resource-modal" maxWidth="2xl" display="justify-start">
                <x-slot name="title">
                    <div class="py-4 text-center">
                        Create Resource
                    </div>
                    <div class="cross-menu" @click.prevent="show = false">
                        &times;
                    </div>
                </x-slot>

                <x-slot name="body">

                    <form action="{{ route('katas.create-resource', $challenge->slug) }}" method="post" class="flex flex-col justify-between items-center">
                        @csrf
                        <div class="w-3/4 py-5">
                            <x-jet-label for="title" value="{{ __('Title') }}" />
                            <x-jet-input id="title" type="text" name="title" class="mt-1 block w-full text-slate-700/70" value="{{ old('title') }}"/>
                            <x-jet-input-error for="title" class="mt-2" id="error-title" />
                            <p id="error-title" class="text-sm text-red-600"></p>
                        </div>

                        <div class="w-3/4 py-5">
                            <x-jet-label for="url" value="{{ __('Url') }}" />
                            <x-jet-input id="url" type="text" name="url" class="mt-1 block w-full text-slate-700/70" value="{{ old('url', '') }}" />
                            <x-jet-input-error for="url" class="mt-2" id="error-url"/>
                            <p id="error-url" class="text-sm text-red-600"></p>
                        </div>

                        <div class="w-3/4 py-5">
                            <x-jet-label for="description" value="{{ __('Description') }}" />

                            <textarea name="description" id="description" type="description" cols="30" rows="5" maxlength="250"
                                      class="w-full block mt-1 rounded-md transition border border-gray-300 text-slate-700/70
                                            dark:bg-[rgb(255,255,255)]/20 dark:text-slate-100
                                            focus:outline-none focus:ring-1 focus:saturate-150 focus:ring-violet-600
                                            dark:focus:shadow-outter-lg dark:focus:ring-transparent
                                            dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30"
                            >{{ old('description', '') }}</textarea>
                            <x-jet-input-error for="description" class="mt-2" id="error-description"/>
                            <p id="error-description" class="text-sm text-red-600"></p>

                        </div>

                        <div class="w-full flex justify-end items-center py-5 pr-5">
                            <x-jet-button id="publish-resource">
                                Publish
                            </x-jet-button>
                        </div>


                    </form>

                </x-slot>

                <x-slot name="footer">

                </x-slot>
            </x-layout.modal>

            <x-layout.modal name="edit-resource-modal" maxWidth="2xl" display="justify-start">
                <x-slot name="title">
                    <div class="py-4 text-center">
                        Edit Resource
                    </div>
                    <div class="cross-menu" @click.prevent="show = false">
                        &times;
                    </div>
                </x-slot>

                <x-slot name="body">
                    <form id="edit-form" x-ref="edit-form" action="" method="post" class="flex flex-col justify-between items-center">
                        @csrf
                        <div class="w-3/4 py-5">
                            <x-jet-label for="title" value="{{ __('Title') }}" />
                            <x-jet-input id="edit-title" x-ref="edit-title" type="text" name="title" class="mt-1 block w-full text-slate-700/70" value="{{ old('title', '' ) }}"/>
                            <x-jet-input-error for="title" class="mt-2" id="error-title" />
                            <p id="edit-error-title" class="text-sm text-red-600"></p>
                        </div>

                        <div class="w-3/4 py-5">
                            <x-jet-label for="url" value="{{ __('Url') }}" />
                            <x-jet-input id="edit-url" x-ref="edit-url" type="text" name="url" class="mt-1 block w-full text-slate-700/70" value="{{ old('url', '') }}" />
                            <x-jet-input-error for="url" class="mt-2" id="error-url"/>
                            <p id="edit-error-url" class="text-sm text-red-600"></p>
                        </div>

                        <div class="w-3/4 py-5">
                            <x-jet-label for="description" value="{{ __('Description') }}" />

                            <textarea name="description" id="edit-description" x-ref="edit-description" type="description" cols="30" rows="5" maxlength="250"
                                      class="w-full block mt-1 rounded-md transition border border-gray-300 text-slate-700/70
                                            dark:bg-[rgb(255,255,255)]/20 dark:text-slate-100
                                            focus:outline-none focus:ring-1 focus:saturate-150 focus:ring-violet-600
                                            dark:focus:shadow-outter-lg dark:focus:ring-transparent
                                            dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30"
                            >{{ old('description', '') }}</textarea>
                            <x-jet-input-error for="description" class="mt-2" id="edit-error-description"/>
                            <p id="edit-error-description" class="text-sm text-red-600"></p>

                        </div>

                        <div class="w-full flex justify-end items-center py-5 pr-5">
                            <x-jet-button id="update-resource">
                                Edit
                            </x-jet-button>
                        </div>


                    </form>

                </x-slot>

                <x-slot name="footer">

                </x-slot>
            </x-layout.modal>

            <x-layout.dinamicflash type="error" name="verifycode"></x-layout.dinamicflash>

            @if (session()->has('syncStatus'))
                <x-layout.flash type="{{ session('syncStatus') }}">
                    {{ session('syncMessage') }}
                </x-layout.flash>
            @endif

        </main>
        <style>
            .ace_active-line {
                background-color: rgba(93, 93, 94, 0.103) !important;
            }

            .ace-solarized-light .ace_gutter  {
                background-color: rgba(180, 180, 180, 0.548) !important;
                color: gray !important;
            }

            .ace-solarized-light .ace_gutter-active-line {
                background-color: rgba(180, 180, 180, 0.548) !important;
            }

            .ace-monokai .ace_gutter {
                background-color: #1311116c !important;
                color: #bebbbb !important;
            }

            .ace-monokai .ace_gutter-active-line {
                background-color: rgba(36, 36, 36, 0.692) !important;
            }
        </style>
        @vite(['resources/js/codekata.js'])
        <script>

            window.addEventListener('DOMContentLoaded', (eDCL) => {
                iodine = new Iodine();

                const rules = {
                    title: ['required', 'string', 'maxLength:255'],
                    url: ['required', 'url', 'maxLength:255'],
                    description: ['required', 'string', 'maxLength:255'],
                };

                document.getElementById('title')
                    .addEventListener('blur', (eBlur) => {
                        let title =  document.getElementById('title').value;
                        let assert = iodine.assert(title, rules.title);
                        console.log(title);
                        if (!assert.valid) {
                            document.getElementById('error-title').textContent = assert.error;
                        } else {
                            document.getElementById('error-title').textContent = '';
                        }
                    });

                document.getElementById('url')
                    .addEventListener('blur', (eBlur) => {
                        let url =  document.getElementById('url').value;
                        let assert = iodine.assert(url, rules.url);
                        if (!assert.valid) {
                            document.getElementById('error-url').textContent = assert.error;
                        } else {
                            document.getElementById('error-url').textContent = '';
                        }
                    });

                document.getElementById('description')
                    .addEventListener('blur', (eBlur) => {
                        let description =  document.getElementById('description').value;
                        let assert = iodine.assert(description, rules.description);
                        if (!assert.valid) {
                            document.getElementById('error-description').textContent = assert.error;
                        } else {
                            document.getElementById('error-description').textContent = '';
                        }
                    });


                document.getElementById('publish-resource').addEventListener('click', (eClick) => {

                    let titleValue =  document.getElementById('title').value;
                    let urlValue =  document.getElementById('url').value;
                    let descriptionValue =  document.getElementById('description').value;

                    let title = iodine.assert(titleValue, rules.title);
                    let url = iodine.assert(urlValue, rules.url);
                    let description = iodine.assert(descriptionValue, rules.description);

                    if (!title.valid && !url.valid && !description.valid) {
                        eClick.preventDefault();
                        eClick.stopImmediatePropagation();
                        if (!title.valid) {
                            document.getElementById('error-title').textContent = title.error;
                        } else {
                            document.getElementById('error-title').textContent = '';
                        }

                        if (!title.valid) {
                            document.getElementById('error-url').textContent = url.error;
                        } else {
                            document.getElementById('error-url').textContent = '';
                        }

                        if (!description.valid) {
                            document.getElementById('error-description').textContent = description.error;
                        } else {
                            document.getElementById('error-description').textContent = '';
                        }
                    }
                })

                // Edit modal

                document.getElementById('edit-title')
                    .addEventListener('blur', (eBlur) => {
                        let title =  document.getElementById('edit-title').value;
                        let assert = iodine.assert(title, rules.title);
                        console.log(title);
                        if (!assert.valid) {
                            document.getElementById('edit-error-title').textContent = assert.error;
                        } else {
                            document.getElementById('edit-error-title').textContent = '';
                        }
                    });

                document.getElementById('edit-url')
                    .addEventListener('blur', (eBlur) => {
                        let url =  document.getElementById('edit-url').value;
                        let assert = iodine.assert(url, rules.url);
                        if (!assert.valid) {
                            document.getElementById('edit-error-url').textContent = assert.error;
                        } else {
                            document.getElementById('edit-error-url').textContent = '';
                        }
                    });

                document.getElementById('edit-description')
                    .addEventListener('blur', (eBlur) => {
                        let description =  document.getElementById('edit-description').value;
                        let assert = iodine.assert(description, rules.description);
                        if (!assert.valid) {
                            document.getElementById('edit-error-description').textContent = assert.error;
                        } else {
                            document.getElementById('edit-error-description').textContent = '';
                        }
                    });


                document.getElementById('update-resource').addEventListener('click', (eClick) => {

                    let titleValue =  document.getElementById('edit-title').value;
                    let urlValue =  document.getElementById('edit-url').value;
                    let descriptionValue =  document.getElementById('edit-description').value;

                    let title = iodine.assert(titleValue, rules.title);
                    let url = iodine.assert(urlValue, rules.url);
                    let description = iodine.assert(descriptionValue, rules.description);

                    if (!title.valid && !url.valid && !description.valid) {
                        eClick.preventDefault();
                        eClick.stopImmediatePropagation();
                        if (!title.valid) {
                            document.getElementById('edit-error-title').textContent = title.error;
                        } else {
                            document.getElementById('edit-error-title').textContent = '';
                        }

                        if (!title.valid) {
                            document.getElementById('edit-error-url').textContent = url.error;
                        } else {
                            document.getElementById('edit-error-url').textContent = '';
                        }

                        if (!description.valid) {
                            document.getElementById('edit-error-description').textContent = description.error;
                        } else {
                            document.getElementById('edit-error-description').textContent = '';
                        }
                    }
                })

            });


        </script>
    </x-layout.wrapped-main-section>
</x-app-layout>



