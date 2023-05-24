@foreach ($users as $user)

    <div class="card-users sm:mt-4 relative">
        <a href="{{ $user->profile->url }}">

            <div class="absolute top-3 left-3">
                <x-utilities.rank size="4" :rank="$user->profile->rank->name" />
            </div>

            <div class="absolute top-3 right-3">
                @if (auth()->user()->following?->get()->contains($user->id))
                    <x-jet-button x-on:click.prevent="">Unfollow</x-jet-button>
                @else
                    <x-jet-button x-on:click.prevent="">Follow</x-jet-button>
                @endif
            </div>

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