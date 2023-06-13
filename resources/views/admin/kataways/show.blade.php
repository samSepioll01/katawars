<x-app-layout>
    <x-layout.wrapped-admin-sections>
        <div class="flex flex-row justify-start w-full py-2">
            <form action="{{ route('admin.kataways.index') }}" method="get" class="px-5">
                <x-jet-button id="" class="w-32 flex justify-center">Back</x-jet-button>
            </form>
        </div>

        <div class="flex flex-col lg:flex-row w-full justify-start items-center px-5 py-8">

            <div class="flex flex-row justify-end lg:w-1/2 py-5">
                <form action="{{ route('kataways.destroy', $kataway) }}" method="post" class="px-5 py-2">
                    @csrf
                    @method('DELETE')
                    <x-jet-danger-button type="submit" class="w-32 flex justify-center">Delete</x-jet-danger-button>
                </form>
            </div>

        </div>

        <div class="pl-5 py-5 flex flex-col lg:flex-row w-full">

            <div class="lg:w-1/2">
                <table class="my-10">
                    <thead class="text-gray-800 text-2xl font-semibold w-full">
                        <tr class="w-full">
                            <div class="text-3xl font-semibold flex justify-start">{{ $kataway->title }}</div>
                        </tr>
                    </thead>
                    <tbody class="">
                        <tr>
                            <td class="pr-10">Description</td>
                            <td class="py-5">{!! $kataway->description !!}</td>
                        </tr>
                        <tr>
                            <td>Owner</td>
                            <td class="max-w-lg flex flex-row items-center py-5">
                                <img src="{{ $kataway->createdByProfile->user->profile_photo_url }}" class="h-6 w-6 rounded-full" alt="">
                                <div class="pl-2">
                                    {{ $kataway->createdByProfile->user->name }}
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <td>Challenges</td>
                            <td>
                                @foreach ($kataway->katas as $kata)
                                    <p class="py-1">{{ $kata->challenge->title }}</p>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>Subscribers</td>
                            <td class="py-5">{!! $kataway->startedByProfiles->count() !!}</td>
                        </tr>

                        <tr>
                            <td>Users Complete</td>
                            <td class="py-5">{{ $kataway->completedByProfiles()->count() }}</td>
                        </tr>

                        <tr>
                            <td>Created At</td>
                            <td class="py-5">{{ $kataway->created_at }}</td>
                        </tr>

                        <tr>
                            <td>Updated At</td>
                            <td class="py-5">{{ $kataway->updated_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

    </x-layout.wrapped-admin-sections>
</x-app-layout>
