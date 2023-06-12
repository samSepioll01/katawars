<x-app-layout>
    <x-layout.wrapped-admin-sections>
        <div class="flex flex-row justify-start w-full py-2">
            <form action="{{ route('users.comments', ['user' => $user]) }}" method="get" class="px-5">
                <x-jet-button id="" class="w-32 flex justify-center">Back</x-jet-button>
            </form>
        </div>

        <div class="flex flex-col lg:flex-row w-full justify-start items-center px-5 py-8">

            <div class="w-full flex flex-row items-center">
                <div class="w-32 h-32 flex items-center">
                    <img class="h-32 w-32 rounded-full" src="{{ $user->profile_photo_url }}" alt="">
                </div>

                <div class="flex flex-col justify-center items-start w-1/2 pl-5">
                    <h1 class="text-slate-800 text-2xl w-full">
                        {{ $user->name }}
                    </h1>
                    <div class="text-sm">
                        {{ $user->email }}
                    </div>
                </div>
            </div>

            <div class="flex flex-row justify-end lg:w-1/2 py-5">
                <form action="{{ route('users.comments.destroy', ['user' => $user, 'comment' => $comment]) }}" method="post" class="px-5 py-2">
                    @csrf
                    @method('DELETE')
                    <x-jet-button id="" class="w-32 flex justify-center">Delete</x-jet-button>
                </form>
            </div>

        </div>

        <div class="pl-5 py-5 flex flex-col lg:flex-row w-full">

            <div class="lg:w-1/2">
                <table class="my-10">
                    <thead class="text-gray-800 text-2xl font-semibold w-full">
                        <tr class="w-full">
                            <div class="text-3xl font-semibold flex justify-start">
                                <a href="{{ $comment->challenge->url }}">
                                    {{ $comment->challenge->title }}
                                </a>

                            </div>
                        </tr>
                    </thead>
                    <tbody class="">
                        <tr>
                            <td class="pr-10">Comment</td>
                            <td class="py-5">{!! $comment->body !!}</td>
                        </tr>
                        <tr>
                            <td>Created At</td>
                            <td>{{ $comment->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Updated At</td>
                            <td>{{ $comment->updated_at }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>

    </x-layout.wrapped-admin-sections>
</x-app-layout>
