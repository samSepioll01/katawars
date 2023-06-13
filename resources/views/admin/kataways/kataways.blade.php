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
                    <h1 class="text-gray-800 text-2xl font-semibold">Created Kataways</h1>
                </div>

                <div class="col-span-12 lg:col-span-8 py-5">
                    <x-layout.searcher-sync route="{{ route('admin.kataways.index') }}" />
                </div>

                <div class="col-span-12 lg:col-span-4 py-5">

                    <div class="flex flex-row items-center justify-end gap-4">
                        <form action="{{ route('kataways.create') }}" method="get">
                            <x-jet-button>Create</x-jet-button>
                        </form>
                    </div>
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
                                        <span class="pl-2">Title</span>
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Owner
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Challenges
                                    </th>

                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Subscribers
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Users Completed
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Created at
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @if ($kataways->count())
                                    @foreach ($kataways as $kataway )
                                        <tr>

                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <a href="{{ route('admin.kataways.show', $kataway) }}" class="flex items-center">
                                                    <span>{{ $kataway->title }}</span>
                                                </a>
                                            </td>

                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                {{ $kataway->description }}
                                            </td>

                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <div class="flex items-center">
                                                    <img src="{{ $kataway->createdByProfile->user->profile_photo_url }}" class="h-6 w-6 rounded-full" alt="">
                                                    <span class="px-2 text-gray-900 whitespace-no-wrap">
                                                        {{ $kataway->createdByProfile->user->name }}
                                                    </span>
                                                </div>
                                            </td>

                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                @foreach ($kataway->katas as $kata)
                                                    <p>{{ $kata->challenge->name }}</p>
                                                @endforeach
                                            </td>

                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <span>{{ $kataway->startedByProfiles->count() }}</span>
                                            </td>

                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <span>{{ $kataway->completedByProfiles()->count() }}</span>
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <span>{{ $kataway->created_at }}</span>
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
                {{ $kataways->links() }}
            </div>
        </div>
    </x-layout.wrapped-admin-sections>

</x-app-layout>
