<x-app-layout>

    <x-layout.wrapped-admin-sections>
        <header>
            <div class="flex flex-row justify-start w-1/2 py-2">
                <form action="{{ route('admin.helps.show', $help) }}" method="get" class="px-5">
                    <x-jet-button id="" class="w-32 flex justify-center">Back</x-jet-button>
                </form>
            </div>

            <div class="flex justify-center items-center">
                <h1 class="text-3xl font-semibold">Create Help</h1>
            </div>
        </header>
        <main class="">
            <form action="{{ route('admin.helps.update', $help) }}" method="post">
                @csrf
                @method('PUT')
                <div class="py-20">

                    <div class="w-full flex flex-col gap-8">
                        <div class="w-full lg:w-1/2">
                            <label for="title" class="text-violet-600 text-sm">Title</label>
                            <input id="title" type="text" name="title" class="w-full border border-gray-300 rounded-md transition
                                dark:bg-[rgb(255,255,255)]/20 focus:outline-none focus:ring-1
                                    focus:saturate-150 focus:ring-violet-600 dark:focus:shadow-outter-lg dark:focus:ring-transparent
                                dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30'"
                                value="{{ old('title', $help->title) }}"
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
                            >{{ old('description', $help->description) }}</textarea>

                            <x-jet-input-error for="description" class="mt-2" />

                        </div>

                        <div class="w-full lg:w-1/2">
                            <label for="section" class="text-violet-600 text-sm">Section</label>
                            <input id="section" name="section" type="text" class="w-full border border-gray-300 rounded-md transition
                                dark:bg-[rgb(255,255,255)]/20 focus:outline-none focus:ring-1
                                    focus:saturate-150 focus:ring-violet-600 dark:focus:shadow-outter-lg dark:focus:ring-transparent
                                dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30'"
                                value="{{ old('section', $help->section) }}"
                            >
                            <x-jet-input-error for="section" class="mt-2" />
                        </div>
                    </div>

                    <div class="pt-20 flex justify-start w-full">
                        <x-jet-button>UPDATE</x-jet-button>
                    </div>
                </div>
            </form>
        </main>
    </x-layout.wrapped-admin-sections>

</x-app-layout>
