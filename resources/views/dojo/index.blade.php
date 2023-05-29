<x-app-layout>
    <x-layout.wrapped-main-section>

        <x-layout.searcher route="/dojo" />

        <main class="mt-20 flex flex-col">

            <div class="relative p-5 md:px-12 lg:px-36 grid grid-cols-1 gap-5 md:grid-cols-2 lg:max-w-none xl:grid-cols-3" x-ref="users">
                @foreach ($users as $user)

                        <div class="card-users sm:mt-4 relative">
                            <a href="{{ $user->profile->url }}">

                                <div class="absolute top-3 left-3">
                                    <x-utilities.rank size="4" :rank="$user->profile->rank->name" />
                                </div>

                                @livewire('follow-button', ['profile' => $user->profile])

                                <div class="w-full h-full flex flex-row items-center justify-start pl-7">

                                    <div>
                                        <img src="{{ $user->profile_photo_url }}" class="w-24 h-24 rounded-full" alt="" />
                                    </div>

                                    <div class="text-lg pl-4">
                                        <span>
                                            {{ $user->name }}
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
