<x-app-layout>
    <x-layout.wrapped-main-section>

        <main class="grid grid-cols-12 mt-8 gap-8">
            <div class="max-h-screen col-span-12 lg:col-span-4 sm:rounded-xl relative">

                <div class="h-full w-full border overflow-hidden border-blue-600 -z-10 absolute sm:rounded-xl">
                    <img class="w-full h-full saturate-150" src="{{ $kataway->createdByProfile->user->profile_photo_url }}" alt="">
                </div>

                <div class="p-10 sm:border border-slate-400 sm:dark:border-cyan-600 shadow-xl sm:dark:shadow-outter-sm sm:dark:shadow-cyan-600 sm:rounded-xl bg-slate-200/70 dark:bg-slate-800/30 backdrop-blur-xl lg:min-h-screen">

                    <div class="text-slate-700 dark:text-slate-100">
                        <div class="pb-10 text-lg">
                            <a href="{{ route('users.main', $kataway->createdByProfile->slug) }}" class="inline-flex items-center">
                                <div class="overflow-hidden rounded-full pr-3">
                                    <img class="h-12 w-12 rounded-full" src="{{ $kataway->createdByProfile->user->profile_photo_url }}" alt="">
                                </div>
                                <div>
                                    {{ auth()->user()->name }}
                                </div>
                            </a>
                        </div>

                        <div class="text-4xl font-bold tracking-wider">
                            {{ __($kataway->title) }}
                        </div>
                        <div class="text-md text-slate-800 dark:text-slate-100 py-8">
                            {{ __($kataway->description) }}
                        </div>

                        <div class="w-full pt text-sm pt-10 flex flex-col justify-evenly items-center gap-4">
                            <span>{{ $kataway->katas->count() }} Challenges</span>
                            @if (auth()->user()->profile->startedKataways->contains($kataway))
                                <form action="{{ route('kataways.unsubscribe', $kataway) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <x-jet-button>
                                        Unsubscribe
                                    </x-jet-button>
                                </form>

                                <span> {{ $completedKatas->count() }} / {{ $kataway->katas->count() }} Challenges Remmained</span>

                            @else
                                <form action="{{ route('kataways.subscribe', $kataway) }}" method="post">
                                    @csrf
                                    <x-jet-button>
                                        Subscribe
                                    </x-jet-button>
                                </form>
                            @endif


                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-8 py-2" x-ref="challenges">

                @if ($isSubscribe && $completedKatas->count() === $kataway->katas->count())
                    <div class="inline-flex items-center py-2">
                        @if ($kataway->scoredBy(auth()->user()->id))
                            <span class="pr-2">You have won points with this Kataway! </span>

                        @else
                            <div class="inline-flex items-center py-2">
                                <span class="pr-2">Congrats!! You Completed this Kataway!! </span>
                                <form action="{{ route('kataways.complete', $kataway) }}" method="post">
                                    @csrf
                                    <x-jet-button>
                                        Get Points
                                    </x-jet-button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endif

                <div id="list" class="lista" x-ref="list">
                    @foreach ($kataway->katas as $kata)

                        <div class="card-challenge grid grid-cols-12 relative" id="{{ $kata->id }}">

                            @if ($isSubscribe && $completedKatas->contains($kata))
                                <div class="border border-green rounded-lg py-1 px-2 w-fit h-fit absolute right-2 top-2 text-sm text-green-800 bg-green-200">
                                    Completed
                                </div>
                            @endif

                            <div class="col-span-11 relative">
                                <div class="w-full flex flex-row justify-between">
                                    <div class="w-full flex flex-row justify-start items-center">
                                        @foreach ($kata->challenge->categories as $category )
                                            <a href="{{ route('challenges.training') }}?category={{$category->name}}">
                                                <div class="bg-slate-50 dark:bg-slate-900 border border-slate-400 dark:border-slate-800 shadow-md hover:bg-violet-600 dark:hover:bg-violet-600 hover:text-slate-100 cursor-pointer px-2 rounded-lg mr-2">
                                                    <span class="category">{{ $category->name }}</span>
                                                </div>
                                            </a>

                                        @endforeach
                                        <x-utilities.rank size="4" :rank="$kata->challenge->rank->name" />
                                    </div>
                                </div>

                                <div class="py-2">
                                    <a href="{{ $kata->challenge->url }}" class="">
                                        <div class="text-center text-ellipsis-1 text-xl text-violet-600 dark:text-tomato">
                                            {{ $kata->challenge->title }}
                                        </div>
                                        <div class="text-ellipsis-3">
                                            <span>
                                                {!! $kata->challenge->description !!}
                                            </span>
                                        </div>
                                    </a>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

        </main>
    </x-layout.wrapped-main-section>
</x-app-layout>
