<x-app-layout>
    <x-layout.wrapped-admin-sections>
        <div class="w-full p-8 flex justify-center items center">
            <h1 class="text-2xl font-semibold">Edit User</h1>
        </div>

        <div>
            <h1 class="text-xl font-semibold py-3">{{ $user->name }} Photos</h1>
            <div class="flex flex-col lg:flex-row gap-4">
                @foreach ($profilePhotos as $photo)
                    <div class="flex flex-row md:flex-col justify-center items-center">
                        <img class="w-32 h-32 rounded-lg" src="{{ $photo }}" alt="">
                        <form action="{{ route('users.delete.photo', ['user' => $user, 'index' => $profilePhotos->search($photo)]) }}" method="post" class="w-full flex justify-center items-center py-3">
                            @csrf
                            <x-jet-button>Delete</x-jet-button>
                        </form>
                    </div>

                @endforeach
            </div>
        </div>

    </x-layout.wrapped-admin-sections>
</x-app-layout>
