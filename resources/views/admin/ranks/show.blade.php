<x-app-layout>
    <x-layout.wrapped-admin-sections>
        <div class="flex flex-row justify-start w-full py-2">
            <form action="{{ route('ranks.index') }}" method="get" class="px-5">
                <x-jet-button class="w-32 flex justify-center">Back</x-jet-button>
            </form>
        </div>

        <div class="flex flex-col lg:flex-row w-full justify-end items-center px-5 py-8">

            <div class="py-5">
                <form action="{{ route('ranks.edit', $rank) }}" method="get" class="px-5 py-2">
                    <x-jet-button class="w-32 flex justify-center">Edit</x-jet-button>
                </form>
            </div>

        </div>

        <div class="pl-5 py-5 flex flex-col lg:flex-row w-full">

            <div class="lg:w-1/2">
                <table class="my-10">
                    <thead class="text-gray-800 text-2xl font-semibold w-full">
                        <tr class="w-full">
                            <div class="text-3xl font-semibold flex justify-start">{{ ucwords($rank->name) }}</div>
                        </tr>
                    </thead>
                    <tbody class="">
                        <tr>
                            <td class="pr-10">Name</td>
                            <td class="py-5">{{ ucwords($rank->name) }}</td>
                        </tr>
                        <tr>
                            <td class="pr-10">Level Up (to increase the next Level).</td>
                            <td class="py-5">{{ $rank->level_up }}</td>
                        </tr>
                        <tr>
                            <td>Created At</td>
                            <td>{{ $rank->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Updated At</td>
                            <td>{{ $rank->updated_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

    </x-layout.wrapped-admin-sections>
</x-app-layout>
