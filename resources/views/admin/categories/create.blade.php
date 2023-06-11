<x-app-layout>

    <x-layout.wrapped-admin-sections>
        <header>
            <div class="flex flex-row justify-start w-1/2 py-2">
                <form action="{{ route('admin.categories.index') }}" method="get" class="px-5">
                    <x-jet-button id="" class="w-32 flex justify-center">Back</x-jet-button>
                </form>
            </div>

            <div class="flex justify-center items-center">
                <h1 class="text-3xl font-semibold">Create Category</h1>
            </div>
        </header>
        <main class="">
            <form action="{{ route('admin.categories.store') }}" method="post">
                @csrf
                <div class="py-20">

                    <div class="w-full flex flex-col gap-8">
                        <div class="w-full lg:w-1/2">
                            <label for="name" class="text-violet-600 text-sm">Name</label>
                            <input id="name" type="text" name="name" class="w-full border border-gray-300 rounded-md transition
                                dark:bg-[rgb(255,255,255)]/20 focus:outline-none focus:ring-1
                                    focus:saturate-150 focus:ring-violet-600 dark:focus:shadow-outter-lg dark:focus:ring-transparent
                                dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30'"
                                value="{{ old('name') }}"
                            >
                            <x-jet-input-error for="name" class="mt-2" />
                        </div>

                        <div class="w-full lg:w-1/2">
                            <label for="bgcolor" class="text-violet-600 text-sm">Background Color</label>
                            <input id="bgcolor" type="text" name="bgcolor" class="w-full border border-gray-300 rounded-md transition
                                dark:bg-[rgb(255,255,255)]/20 focus:outline-none focus:ring-1
                                    focus:saturate-150 focus:ring-violet-600 dark:focus:shadow-outter-lg dark:focus:ring-transparent
                                dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30'"
                                value="{{ old('bgcolor') }}"
                            >
                            <x-jet-input-error for="bgcolor" class="mt-2" />
                        </div>
                    </div>

                    <div class="pt-20 flex justify-start w-full">
                        <x-jet-button>Create</x-jet-button>
                    </div>
                </div>
            </form>
        </main>
    </x-layout.wrapped-admin-sections>

</x-app-layout>
