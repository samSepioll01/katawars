<x-app-layout>

    <div class="bg-white dark:bg-slate-800/50 p-10 border border-red-600">

        <div class="py-5 flex flex-row justify-between">
            <form action="{{ route('users.change', ['id' => $previous]) }}" method="get">
                <x-jet-button class="w-32 flex justify-center">Previous</x-jet-button>
            </form>

            <form action="{{ route('users.change', ['id' => $next]) }}" method="get">
                <x-jet-button id="next_btn" class="w-32 flex justify-center">Next</x-jet-button>
            </form>

        </div>

        <div class="py-8 flex flex-row justify-between w-full border border-red-600">
            <div class="flex flex-row justify-start w-1/2">
                <form action="{{ route('users.index') }}" method="get" class="px-5">
                    <x-jet-button id="" class="w-32 flex justify-center">Back</x-jet-button>
                </form>
            </div>
            <div class="flex flex-row justify-end w-1/2">

                <form action="" method="get" class="px-5">
                    <x-jet-button id="" class="w-32 flex justify-center">Edit</x-jet-button>
                </form>

                <form action="" method="get" class="px-5">
                    <x-jet-button id="" class="w-32 flex justify-center">To Ban</x-jet-button>
                </form>

                <form action="" method="get" class="px-5">
                    <x-jet-button id="" class="w-32 flex justify-center">Delete</x-jet-button>
                </form>

            </div>
        </div>

        <div class="flex flex-row w-full justify-start items-center border border-blue-600">
            <div class="w-32 h-32 flex items-center">
                <img class="h-32 w-32 rounded-full" src="{{ $user->profile_photo_url }}" alt="">
            </div>

            <div class="w-32 h-32 flex justify-center items-center">
                <h1 class="text-slate-800/70 dark:text-slate-100 text-2xl">
                    {{ $user->name }}
                </h1>
            </div>

        </div>

        <div>
            tabla usuario
        </div>

    </div>



</x-app-layout>
