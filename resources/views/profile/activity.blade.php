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
                            {{ __('My Comments') }}
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
                                >{{ $totalComments }}</span> Published Comments</span>
                            <span>Updated {{ $lastUpdated ?? 'never' }}</span>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-span-12 lg:col-span-8 py-2" x-ref="challenges">

                @if ($totalComments)
                    <x-layout.order-button-sync route="{{ route('profile.activity') }}" />
                    <div id="list" class="lista" x-ref="list">

                        @foreach ($comments as $comment)

                            @if (request()->routeIs('profile.activity'))
                                <div class="w-3/4 flex justify-start py-2 pl-32">
                                    @if ($comment->parent)
                                        <span class="text-sm text-slate-800 dark:text-slate-100 p-2">Replied To: {{ $comment->parent->author->user->name }}</span>
                                    @endif
                                    <x-layout.button-link href="{{ $comment->challenge->url }}">See</x-layout.button-link>
                                </div>

                            @endif
                            <div class="w-full test-slate-800 dark:text-slate-100 flex flex-col items-center gap-8 justify-center" x-data="{open: false}">
                                <x-layout.challenge-comment :comment="$comment" :challenge="$comment->challenge"/>

                                @if ($comment->replies->count())
                                    <div class="">
                                        <p class="text-sm hover:text-violet-600 cursor-pointer"
                                        @click="open = !open"
                                        >
                                            Replies({{ $comment->replies->count() }})
                                        </p>
                                    </div>
                                @endif

                                <div class="w-full max-h-0 flex flex-col items-center gap-3 justify-center overflow-hidden transition-all duration-200"
                                    :style=" open ? 'max-height: ' + ($el.scrollHeight * 2) + 'px;' : '' "
                                >
                                    @foreach ($comment->replies as $reply)
                                        <x-layout.challenge-comment :comment="$reply" :challenge="$comment->challenge" :reply="true" />
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <h1 class="flex items-center text-lg dark:text-slate-100 font-semibold justify-center">Your list its empty.</h1>
                @endif
            </div>


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
