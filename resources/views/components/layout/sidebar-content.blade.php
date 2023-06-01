<div>

    @if (auth()->user()->email_verified_at)
        <div class="w-full pb-4 px-1 text-gray-700 dark:text-slate-200">
            <x-layout.progress-bar size="4" title="Rank {{ ucwords(auth()->user()->profile->rank->name) }} Progress" :sidebar="true" />
        </div>
    @endif



    <x-layout.dropdown-separator />

    <x-jet-dropdown-link href="{{ route('dojo.index') }}" class="text-md 2xl: items-center">
        <x-layout.dropdown-icon srcPath="dojo" class="mr-6" sidebar/>
        {{ __('Dojo') }}
    </x-jet-dropdown-link>

    <x-layout.dropdown-separator />

    <x-jet-dropdown-link href="{{ route('challenges.training') }}" class="text-md items-center">
        <x-layout.dropdown-icon srcPath="training" class="mr-6" sidebar/>
        {{ __('Training') }}
    </x-jet-dropdown-link>

    <x-jet-dropdown-link href="{{ route('dashboard') }}" class="text-md items-center">
        <x-layout.dropdown-icon srcPath="blitz" class="mr-6" sidebar/>
        {{ __('Blitz') }}
    </x-jet-dropdown-link>

    <x-jet-dropdown-link href="{{ route('dashboard') }}" class="text-md items-center">
        <x-layout.dropdown-icon srcPath="kata-ways" class="mr-6" sidebar/>
        {{ __('Kata Ways') }}
    </x-jet-dropdown-link>

    <x-jet-dropdown-link href="{{ route('dashboard') }}" class="text-md items-center">
        <x-layout.dropdown-icon srcPath="kumite" class="mr-6" sidebar/>
        {{ __('Kumite') }}
    </x-jet-dropdown-link>

    <x-layout.dropdown-separator />

    <x-jet-dropdown-link href="{{ route('dashboard') }}" class="text-md items-center">
        <x-layout.dropdown-icon srcPath="my-katas" class="mr-6" sidebar/>
        {{ __('My Katas') }}
    </x-jet-dropdown-link>

    <x-jet-dropdown-link href="{{ route('katas.saved') }}" class="text-md items-center">
        <x-layout.dropdown-icon srcPath="saved-katas" class="mr-6" sidebar/>
        {{ __('Saved Katas') }}
    </x-jet-dropdown-link>

    <x-jet-dropdown-link href="{{ route('katas.favorites') }}" class="text-md items-center">
        <x-layout.dropdown-icon srcPath="favorites" class="mr-6" sidebar />
        {{ __('Favorites') }}
    </x-jet-dropdown-link>

    <x-layout.dropdown-separator />

    <div>

        @if (auth()->user()->profile->following->count())
        <div class="text-lg text-700 dark:text-slate-100 pb-3">
            {{__('Following')}}
        </div>
        @foreach (auth()->user()->profile->following as $followee )
            <x-jet-dropdown-link href="{{ $followee->url }}" class="text-md items-center">
                <div>
                    <img class="h-10 w-10 hover:scale-105 rounded-full" src="{{ $followee->user->profile_photo_url }}" alt="">
                </div>
                <div class="px-3">
                    {{ __($followee->user->name) }}
                </div>

            </x-jet-dropdown-link>

        @endforeach
        @endif


    </div>

</div>
