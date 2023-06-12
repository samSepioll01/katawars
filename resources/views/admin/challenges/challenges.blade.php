<x-app-layout>
    <x-layout.wrapped-admin-sections>

        <div class="flex flex-row justify-start w-full py-2">
            <form action="{{ route('admin.panel') }}" method="get" class="px-5">
                <x-jet-button id="" class="w-32 flex justify-center">Back</x-jet-button>
            </form>
        </div>



        <div class="w-full" x-data="{showDeleteBTN: false}">
            <div class="py-3 flex flex-col">
                <div>
                    <h1 class="text-gray-800 text-2xl font-semibold">Created Challenges</h1>
                </div>

                <div class="col-span-12 lg:col-span-8 py-5">
                    <x-layout.searcher-sync route="{{ route('challenges.index') }}" />
                </div>

                <div class="col-span-12 lg:col-span-4 py-5">

                    <div class="flex flex-row items-center justify-end gap-4">
                        <form action="{{ route('mykatas.create') }}" method="get">
                            <x-jet-button>Create</x-jet-button>
                        </form>
                    </div>
                </div>


                <div class="py-5 w-full flex justify-end">

                    <x-jet-danger-button type="button" id="deleteBTN" class="w-32 flex justify-center" x-ref="deletebtn" x-show="showDeleteBTN" style="display: none;"
                        x-on:click="
                            checkboxes = [...document.getElementsByName('challenges[]')];
                            selecteds = checkboxes.filter(checkbox => checkbox.checked);
                            ids = selecteds.map(selected => selected.id);
                            axios({
                                method: 'delete',
                                url: '{{ route('users.challenges.delete-multiple', ['user' => auth()->user()]) }}',
                                responseType: 'json',
                                data: {
                                    'ids': ids,
                                }
                            })
                            .then(response => {
                                if (response.data.success) {
                                    window.location.reload();
                                }
                            })
                            .catch(errors => console.log(errors.message));
                        "
                    >
                        Delete
                    </x-jet-danger-button>

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
                                                checkboxes = [...document.getElementsByName('challenges[]')];

                                                if ($event.target.checked) {
                                                    showDeleteBTN = true;
                                                    checkboxes.forEach(checkbox => checkbox.checked = true);
                                                } else {
                                                    showDeleteBTN = false;
                                                    checkboxes.forEach(checkbox => checkbox.checked = false);
                                                }
                                            ">
                                            <span class="pl-2">Title</span>
                                        </div>

                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        URL
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Rank
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Language
                                    </th>

                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Mode
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Created at
                                    </th>
                                </tr>
                            </thead>

                            <tbody x-on:click="
                                if ($event.target.type === 'checkbox') {
                                    if ($event.target.checked) {
                                        showDeleteBTN = true;
                                    } else {
                                        checkboxes = [...document.getElementsByName('challenges[]')];
                                        if (checkboxes.every(checkbox => !checkbox.checked)) {
                                            showDeleteBTN = false;
                                        }
                                    }
                                }
                            "
                            >
                                @if ($challenges->count())
                                    @foreach ($challenges as $challenge )
                                        <tr>

                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <a href="{{ route('challenges.show', ['challenge' => $challenge]) }}" class="flex items-center">
                                                    <input type="checkbox" name="challenges[]" class="mr-2" id="{{ $challenge->id }}">
                                                    <span>{{ $challenge->title }}</span>
                                                </a>
                                            </td>

                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <a href="{{ $challenge->url }}" class="">
                                                    {{ $challenge->url }}
                                                </a>
                                            </td>

                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <div class="flex items-center">
                                                    <x-utilities.rank :size="4" rank="{{ $challenge->rank->name }}" />
                                                    <span class="px-2 text-gray-900 whitespace-no-wrap">
                                                        {{ ucwords($challenge->rank->name) }}
                                                    </span>
                                                </div>
                                            </td>

                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <span>{{ ucwords($challenge->katas->first()->language->name) }}</span>
                                            </td>

                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <span>{{ ucwords($challenge->katas->first()->mode->denomination) }}</span>
                                            </td>

                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <span>{{ $challenge->created_at }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="6" class="py-4 text-xl font-semibold text-center">No Challenges founded.</td>
                                </tr>

                                @endif

                            </tbody>
                        </table>
            <div class="relative flex flex-col justify-between p-5">
                {{ $challenges->links() }}
            </div>
        </div>
    </x-layout.wrapped-admin-sections>

</x-app-layout>
