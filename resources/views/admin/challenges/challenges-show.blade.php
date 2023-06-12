<x-app-layout>
    <x-layout.wrapped-admin-sections>
        @vite(['resources/css/prism.css', 'resources/js/prism.js'])
        <div class="flex flex-row justify-start w-full py-2">
            <form action="{{ route('challenges.index') }}" method="get" class="px-5">
                <x-jet-button id="" class="w-32 flex justify-center">Back</x-jet-button>
            </form>
        </div>

        <div class="flex flex-col lg:flex-row w-full justify-end items-center px-5 py-8">

            <div class="py-5">
                <form action="{{ route('mykatas.edit', $challenge) }}" method="get" class="px-5 py-2">
                    <x-jet-button class="w-32 flex justify-center">Edit</x-jet-button>
                </form>
            </div>

            <div class="py-5">
                <form action="{{ route('challenges.destroy', $challenge) }}" method="post" class="px-5 py-2">
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
                            <div class="text-3xl font-semibold flex justify-start">{{ $challenge->title }}</div>
                        </tr>
                    </thead>
                    <tbody class="">
                        <tr>
                            <td class="pr-10">Description</td>
                            <td class="py-5">{!! $challenge->description !!}</td>
                        </tr>
                        <tr>
                            <td>Rank</td>
                            <td class="max-w-lg flex flex-row items-center py-5">
                                <x-utilities.rank :size="4" rank="{{ $challenge->rank->name }}" />
                                <div class="pl-2">
                                    {{ ucwords($challenge->rank->name) }}
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <td>Slug</td>
                            <td class="py-5">{{ $challenge->slug }}</td>
                        </tr>
                        <tr>
                            <td>Examples</td>
                            <td class="py-5">{!! $challenge->examples !!}</td>
                        </tr>

                        <tr>
                            <td>Notes</td>
                            <td class="py-5">{!! $challenge->notes !!}</td>
                        </tr>

                        <tr>
                            <td>Language</td>
                            <td class="py-5">{{ ucwords($challenge->katas->first()->language->name) }}</td>
                        </tr>

                        <tr>
                            <td>Signature</td>
                            <td class="py-5">{{ $challenge->katas->first()->signature }}</td>
                        </tr>

                        <tr>
                            <td>Test Class Name</td>
                            <td class="py-5">{{ $challenge->katas->first()->testClassName }}</td>
                        </tr>

                        <tr>
                            <td>URI Test</td>
                            <td class="py-5">{!! ucwords($challenge->katas->first()->uri_test) !!}</td>
                        </tr>

                        <tr>
                            <td>Created At</td>
                            <td>{{ $challenge->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Updated At</td>
                            <td>{{ $challenge->updated_at }}</td>
                        </tr>

                        <tr>
                            <td class="py-5">Code Test</td>
                        </tr>
                    </tbody>
                </table>
                <div class="overflow-hidden rounded-lg w-full flex justify-start">
                    <pre class="rounded-md"><code class="language-javascript">{{ trim($test_code) }}</code></pre>
                </div>
            </div>

    </x-layout.wrapped-admin-sections>
</x-app-layout>
