<x-app-layout>
    <x-layout.wrapped-admin-sections>

        <div class="flex flex-row justify-start w-full py-2">
            <form action="{{ route('kataways.index') }}" method="get" class="px-5">
                <x-jet-button id="" class="w-32 flex justify-center">Back</x-jet-button>
            </form>
        </div>

        <form action="{{ route('kataways.store') }}" method="post">
            @csrf
            <div class="w-full" x-data="{showCreateBTN: false}">
                <div class="py-3 flex flex-col">
                    <div class="inline-flex justify-center">
                        <h1 class="text-gray-800 text-3xl py-5 font-semibold">Create Kataways</h1>
                    </div>

                    <div class="w-full flex flex-col gap-8 pt-16">
                        <div class="w-full lg:w-1/2">
                            <label for="title" class="text-violet-600 text-sm">Title</label>
                            <input id="title" type="text" name="title" class="w-full border border-gray-300 rounded-md transition
                                dark:bg-[rgb(255,255,255)]/20 focus:outline-none focus:ring-1
                                    focus:saturate-150 focus:ring-violet-600 dark:focus:shadow-outter-lg dark:focus:ring-transparent
                                dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30'"
                                value="{{ old('title') }}"
                            >
                            <x-jet-input-error for="title" class="mt-2" />
                        </div>

                        <div class="w-full lg:w-1/2">
                            <label for="description" class="text-violet-600 text-sm">Description</label>

                            <textarea name="description" id="description" type="description" cols="30" rows="6"
                                class="w-full block mt-1 rounded-md transition border border-gray-300
                                        dark:bg-[rgb(255,255,255)]/20 focus:outline-none focus:ring-1 focus:saturate-150 focus:ring-violet-600
                                        dark:focus:shadow-outter-lg dark:focus:ring-transparent
                                        dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30"
                            >{{ old('description') }}</textarea>

                            <x-jet-input-error for="description" class="mt-2" />

                        </div>
                    </div>

                    <div class="py-5 w-full flex justify-end">

                        <x-jet-button id="createBTN" class="w-32 flex justify-center" x-ref="createbtn" x-show="showCreateBTN" style="display: none;">
                            Create
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
                                                    checkboxes = [...document.getElementsByName('katas[]')];

                                                    if ($event.target.checked) {
                                                        showCreateBTN = true;
                                                        checkboxes.forEach(checkbox => checkbox.checked = true);
                                                    } else {
                                                        showCreateBTN = false;
                                                        checkboxes.forEach(checkbox => checkbox.checked = false);
                                                    }
                                                ">
                                                <span class="pl-2">Title</span>
                                            </div>

                                        </th>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Categories
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
                                            showCreateBTN = true;
                                        } else {
                                            checkboxes = [...document.getElementsByName('katas[]')];
                                            if (checkboxes.every(checkbox => !checkbox.checked)) {
                                                showCreateBTN = false;
                                            }
                                        }
                                    }
                                "
                                >
                                    @if ($challenges->count())
                                        @foreach ($challenges as $challenge )
                                            <tr>
                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    <a href="{{ $challenge->url }}" class="flex items-center">
                                                        <input type="checkbox" name="katas[]" class="mr-2" value="{{ $challenge->katas->first()->id }}"
                                                            @if (in_array($challenge->katas->first()->id, old('katas', []))) checked @endif
                                                        />
                                                        <span>{{ $challenge->title }}</span>
                                                    </a>
                                                </td>

                                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    @foreach ($challenge->categories as $category)
                                                        <span>{{ ucwords($category->name) }} | </span>
                                                    @endforeach
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
                        </div>
                    </div>
                </div>
            </div>
        </form>


    </x-layout.wrapped-admin-sections>

</x-app-layout>
