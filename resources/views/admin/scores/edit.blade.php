<x-app-layout>

    <x-layout.wrapped-admin-sections>
        <header>
            <div class="flex flex-row justify-start w-1/2 py-2">
                <form action="{{ route('scores.show', $score) }}" method="get" class="px-5">
                    <x-jet-button id="" class="w-32 flex justify-center">Back</x-jet-button>
                </form>
            </div>

            <div class="flex justify-center items-center">
                <h1 class="text-3xl font-semibold">Update Score</h1>
            </div>
        </header>
        <main class="">
            <form action="{{ route('scores.update', $score) }}" method="post">
                @csrf
                @method('PUT')
                <div class="py-20">

                    <div class="w-full flex flex-col gap-8">
                        <div class="w-full lg:w-1/2">
                            <label for="denomination" class="text-violet-600 text-sm">Denomination</label>
                            <input id="denomination" type="text" name="denomination" class="w-full border border-gray-300 rounded-md transition
                                dark:bg-[rgb(255,255,255)]/20 focus:outline-none focus:ring-1
                                    focus:saturate-150 focus:ring-violet-600 dark:focus:shadow-outter-lg dark:focus:ring-transparent
                                dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30'"
                                value="{{ old('denomination', $score->denomination) }}"
                            >
                            <x-jet-input-error for="denomination" class="mt-2" />
                        </div>

                        <div class="w-full lg:w-1/2">
                            <label for="type" class="text-violet-600 text-sm">Type</label>
                            <input id="type" name="type" type="text" class="w-full border border-gray-300 rounded-md transition
                                dark:bg-[rgb(255,255,255)]/20 focus:outline-none focus:ring-1
                                    focus:saturate-150 focus:ring-violet-600 dark:focus:shadow-outter-lg dark:focus:ring-transparent
                                dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30'"
                                value="{{ old('type', $score->type) }}"
                            >
                            <x-jet-input-error for="type" class="mt-2" />
                        </div>

                        <div class="w-full lg:w-1/2">
                            <label for="points" class="text-violet-600 text-sm">Points</label>
                            <input id="points" name="points" type="number" class="w-full border border-gray-300 rounded-md transition
                                dark:bg-[rgb(255,255,255)]/20 focus:outline-none focus:ring-1
                                    focus:saturate-150 focus:ring-violet-600 dark:focus:shadow-outter-lg dark:focus:ring-transparent
                                dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30'"
                                value="{{ old('points', $score->points) }}"
                            >
                            <x-jet-input-error for="points" class="mt-2" />
                        </div>
                    </div>

                    <div class="pt-20 flex justify-start w-full">
                        <x-jet-button>Update</x-jet-button>
                    </div>
                </div>
            </form>
        </main>
    </x-layout.wrapped-admin-sections>

</x-app-layout>
