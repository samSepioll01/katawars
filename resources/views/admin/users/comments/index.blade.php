<x-app-layout>
    <x-layout.wrapped-admin-sections>

        <div class="flex flex-row justify-start w-full py-2">
            <form action="{{ route('users.show', ['user' => $user]) }}" method="get" class="px-5">
                <x-jet-button id="" class="w-32 flex justify-center">Back</x-jet-button>
            </form>
        </div>

        <div class="flex flex-col lg:flex-row w-full justify-start items-center px-5 py-5">

            <div class="w-full flex flex-row items-center justify-start">
                <div class="w-32 h-32 flex items-center">
                    <img class="h-32 w-32 rounded-full" src="{{ $user->profile_photo_url }}" alt="">
                </div>

                <div class="flex flex-col justify-center items-start pl-5">
                    <h1 class="text-slate-800 text-2xl w-full">
                        {{ $user->name }}
                    </h1>
                    <div class="text-sm">
                        {{ $user->email }}
                    </div>
                </div>
            </div>

        </div>

        <div class="w-full" x-data="{showDeleteBTN: false}">
            <div class="py-3 flex flex-col">
                <div>
                    <h1 class="text-gray-800 text-2xl font-semibold">Comments Published</h1>
                </div>

                <div class="py-5 w-full flex justify-end">

                    <x-jet-button id="deleteBTN" class="w-32 flex justify-center" x-ref="deletebtn" x-show="showDeleteBTN" style="display: none;"
                        x-on:click="
                            checkboxes = [...document.getElementsByName('comments[]')];
                            selecteds = checkboxes.filter(checkbox => checkbox.checked);
                            ids = selecteds.map(selected => selected.id);

                            axios({
                                method: 'post',
                                url: '{{ route('users.comments.destroy-multiple', ['user' => $user]) }}',
                                responseType: 'json',
                                data: {
                                    ids: ids,
                                }
                            })
                            .then(response => {
                                if (response.data.success) {
                                    window.location.reload();
                                }
                            })
                            .catch(errors => console.log(errors));
                        "
                    >
                        Delete
                    </x-jet-button>

                </div>
            </div>

            <div>
                <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                    <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <div class="flex flex-row items-center">
                                            <input type="checkbox" x-on:click="
                                                checkboxes = [...document.getElementsByName('comments[]')];

                                                if ($event.target.checked) {
                                                    showDeleteBTN = true;
                                                    checkboxes.forEach(checkbox => checkbox.checked = true);
                                                } else {
                                                    showDeleteBTN = false;
                                                    checkboxes.forEach(checkbox => checkbox.checked = false);
                                                }
                                            ">
                                            <span class="pl-2">Body</span>
                                        </div>

                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Challenge
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Created at
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Updated at
                                    </th>
                                </tr>
                            </thead>

                            <tbody x-on:click="
                                if ($event.target.type === 'checkbox') {
                                    if ($event.target.checked) {
                                        showDeleteBTN = true;
                                    } else {
                                        checkboxes = [...document.getElementsByName('comments[]')];
                                        if (checkboxes.every(checkbox => !checkbox.checked)) {
                                            showDeleteBTN = false;
                                        }
                                    }
                                }
                            "
                            >
                                @if ($comments->count())
                                    @foreach ($comments as $comment )
                                        <tr>

                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <a href="{{ route('users.comments.show', ['user' => $user, 'comment' => $comment]) }}" class="flex items-center">
                                                    <input type="checkbox" name="comments[]" class="mr-2" id="{{ $comment->id }}">
                                                    <span>{{ $comment->body }}</span>
                                                </a>
                                            </td>

                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <a href="{{ $comment->challenge->url }}" class="">
                                                    {{ $comment->challenge->title }}
                                                </a>
                                            </td>

                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <span>{{ $comment->created_at }}</span>
                                            </td>

                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <span>{{ $comment->updated_at }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="6" class="py-4 text-xl font-semibold text-center">No Comments founded.</td>
                                </tr>

                                @endif

                            </tbody>
                        </table>
            <div class="relative flex flex-col justify-between p-5">
                {{ $comments->links() }}
            </div>
        </div>
    </x-layout.wrapped-admin-sections>

</x-app-layout>
