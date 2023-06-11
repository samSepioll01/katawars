<x-app-layout>
    <x-layout.wrapped-admin-sections>
        <div class="flex flex-row justify-start w-full py-2">
            <form action="{{ route('admin.helps.index') }}" method="get" class="px-5">
                <x-jet-button id="" class="w-32 flex justify-center">Back</x-jet-button>
            </form>
        </div>

        <div class="flex flex-col lg:flex-row w-full justify-end items-center px-5 py-8">

            <div class="py-5">
                <form action="{{ route('admin.helps.edit', $help) }}" method="get" class="px-5 py-2">
                    <x-jet-button class="w-32 flex justify-center">Edit</x-jet-button>
                </form>
            </div>

            <div class="py-5">
                <form action="{{ route('admin.helps.destroy', $help) }}" method="post" class="px-5 py-2">
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
                            <div class="text-3xl font-semibold flex justify-start">{{ $help->title }}</div>
                        </tr>
                    </thead>
                    <tbody class="">
                        <tr>
                            <td class="pr-10">Title</td>
                            <td class="py-5">{!! $help->title !!}</td>
                        </tr>
                        <tr>
                            <td class="pr-10">Descripton</td>
                            <td class="py-5">{!! $help->description !!}</td>
                        </tr>
                        <tr>
                            <td class="pr-10">Section</td>
                            <td class="py-5">{{ ucwords($help->section) }}</td>
                        </tr>
                        <tr>
                            <td>Created At</td>
                            <td>{{ $help->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Updated At</td>
                            <td>{{ $help->updated_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

    </x-layout.wrapped-admin-sections>
</x-app-layout>
