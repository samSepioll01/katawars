<div>
    <div class="w-full p-6 flex justify-center items-center text-gray-400 dark:text-slate-200 border border-red-600">
        Progress Bar
    </div>

    <x-layout.dropdown-separator />

    <x-jet-dropdown-link href="{{ route('dashboard') }}" class="text-lg items-center">
        <x-layout.dropdown-icon srcPath="dojo" class="mr-6" sidebar/>
        {{ __('Dojo') }}
    </x-jet-dropdown-link>

    <x-layout.dropdown-separator />

    <x-jet-dropdown-link href="{{ route('dashboard') }}" class="text-lg items-center">
        <x-layout.dropdown-icon srcPath="training" class="mr-6" sidebar/>
        {{ __('Training') }}
    </x-jet-dropdown-link>

    <x-jet-dropdown-link href="{{ route('dashboard') }}" class="text-lg items-center">
        <x-layout.dropdown-icon srcPath="blitz" class="mr-6" sidebar/>
        {{ __('Blitz') }}
    </x-jet-dropdown-link>

    <x-jet-dropdown-link href="{{ route('dashboard') }}" class="text-lg items-center">
        <x-layout.dropdown-icon srcPath="kata-ways" class="mr-6" sidebar/>
        {{ __('Kata Ways') }}
    </x-jet-dropdown-link>

    <x-jet-dropdown-link href="{{ route('dashboard') }}" class="text-lg items-center">
        <x-layout.dropdown-icon srcPath="kumite" class="mr-6" sidebar/>
        {{ __('Kumite') }}
    </x-jet-dropdown-link>

    <x-layout.dropdown-separator />

    <x-jet-dropdown-link href="{{ route('dashboard') }}" class="text-lg items-center">
        <x-layout.dropdown-icon srcPath="my-katas" class="mr-6" sidebar/>
        {{ __('My Katas') }}
    </x-jet-dropdown-link>

    <x-jet-dropdown-link href="{{ route('dashboard') }}" class="text-lg items-center">
        <x-layout.dropdown-icon srcPath="saved-katas" class="mr-6" sidebar/>
        {{ __('Saved Katas') }}
    </x-jet-dropdown-link>

    <x-jet-dropdown-link href="{{ route('dashboard') }}" class="text-lg items-center">
        <x-layout.dropdown-icon srcPath="favorites" class="mr-6" sidebar />
        {{ __('Favorites') }}
    </x-jet-dropdown-link>

    <x-layout.dropdown-separator />

</div>