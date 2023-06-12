<x-app-layout>
    <x-layout.wrapped-admin-sections>
        <div class="flex flex-row justify-start w-full py-2">
            <form action="{{ route('scores.index') }}" method="get" class="px-5">
                <x-jet-button class="w-32 flex justify-center">Back</x-jet-button>
            </form>
        </div>

        <div class="flex flex-col lg:flex-row w-full justify-end items-center px-5 py-8">

            <div class="py-5">
                <form action="{{ route('scores.edit', $score) }}" method="get" class="px-5 py-2">
                    <x-jet-button class="w-32 flex justify-center">Edit</x-jet-button>
                </form>
            </div>

            <div class="py-5">
                <form action="{{ route('scores.destroy', $score) }}" method="post" class="px-5 py-2">
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
                            <div class="text-3xl font-semibold flex justify-start">{{ ucwords($score->denomination) }}</div>
                        </tr>
                    </thead>
                    <tbody class="">
                        <tr>
                            <td class="pr-10">Denomination</td>
                            <td class="py-5">{{ ucwords($score->denomination) }}</td>
                        </tr>
                        <tr>
                            <td class="pr-10">Type</td>
                            <td class="py-5">{{ $score->type }}</td>
                        </tr>
                        <tr>
                            <td class="pr-10">Points</td>
                            <td class="py-5">{{ $score->points }}</td>
                        </tr>
                        <tr>
                            <td>Created At</td>
                            <td>{{ $score->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Updated At</td>
                            <td>{{ $score->updated_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

    </x-layout.wrapped-admin-sections>
</x-app-layout>
