<x-app-layout>
    <x-layout.wrapped-main-section>

        <x-layout.searcher action="{{ route('dojo.index') }}" />

        <main class="mt-20 flex flex-col">

            <div class="relative p-5 md:px-12 lg:px-36 grid grid-cols-1 gap-5 md:grid-cols-2 lg:max-w-none xl:grid-cols-3" x-ref="users">
                @foreach ($profiles as $profile)

                        <div class="card-users sm:mt-4 relative">
                            <a href="{{ $profile->url }}">

                                <div class="absolute top-3 left-3">
                                    <x-utilities.rank size="4" :rank="$profile->rank->name" />
                                </div>

                                <div class="absolute top-3 right-3">
                                    @if (auth()->user()->following?->get()->contains($profile->id))
                                        <x-jet-button x-on:click.prevent="">Unfollow</x-jet-button>
                                    @else
                                        <x-jet-button x-on:click.prevent="">Follow</x-jet-button>
                                    @endif
                                </div>

                                <div class="w-full h-full flex flex-row items-center justify-start pl-7">

                                    <div>
                                        <img src="{{ $profile->user->profile_photo_url }}" class="w-24 h-24 rounded-full" alt="" />
                                    </div>


                                    <div class="text-lg pl-4">
                                        <span>
                                            {{ $profile->user->name }}
                                        </span>
                                    </div>

                                </div>
                            </a>
                        </div>

                @endforeach
            </div>
        </main>

    </x-layout.wrapped-main-section>
</x-app-layout>
