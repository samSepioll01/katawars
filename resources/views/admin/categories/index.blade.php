<x-app-layout>
    <div>
        <div class="bg-white dark:bg-slate-800/70 p-8 rounded-md w-full shadow-xl">
            <div>
                <h3 class="text-gray-800 dark:text-slate-100 text-2xl font-semibold">Categories</h3>
            </div>

            <div class=" flex items-center justify-between pb-6">

                <div>
                    <div class="flex flex-row justify-start py-5">
                        <form action="{{ route('admin.panel') }}" method="get" class="">
                            <x-jet-button id="" class="w-32 flex justify-center">Back</x-jet-button>
                        </form>
                    </div>
                </div>

                <div class="w-full grid grid-cols-12">
                    <div class="col-span-12 lg:col-span-8 py-5">
                        <x-layout.searcher-sync route="{{ route('admin.categories.index') }}" />
                    </div>

                    <div class="col-span-12 lg:col-span-4 py-5">

                            <div class="flex flex-row items-center justify-end gap-4">
                                <form action="{{ route('admin.categories.create') }}" method="get">
                                    <x-jet-button>Create</x-jet-button>
                                </form>
                            </div>
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
                                            Name
                                        </th>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Background Color
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

                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <a href="{{ route('admin.categories.show', $category) }}">
                                                    <p class="text-gray-900 whitespace-no-wrap">
                                                        {{ ucwords($category->name) }}
                                                    </p>
                                                </a>
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <span>{!! $category->bg_color !!}</span>
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <span>{{ $category->created_at }}</span>
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <span>{{ $category->updated_at }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
                                {{ $categories->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
    </div>
</x-app-layout>
