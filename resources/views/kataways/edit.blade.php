<x-app-layout>
    <x-layout.wrapped-admin-sections>

        <div class="flex flex-row justify-start w-full py-2">
            <form action="{{ route('kataways.show', $kataway) }}" method="get" class="px-5">
                <x-jet-button id="" class="w-32 flex justify-center">Back</x-jet-button>
            </form>
        </div>

        <form action="{{ route('kataways.update', $kataway) }}" method="post">
            @csrf
            @method('PATCH')
            <div class="w-full" x-data="{showCreateBTN: false}">
                <div class="py-3 flex flex-col">
                    <div class="inline-flex justify-center">
                        <h1 class="text-gray-800 text-3xl py-5 font-semibold">Updated Kataways</h1>
                    </div>

                    <div>
                        <h1 class="text-gray-800 text-xl py-5 font-semibold">{{ $kataway->title }}</h1>
                    </div>

                    <div class="w-full flex flex-col gap-8 pt-16">
                        <div class="w-full lg:w-1/2">
                            <label for="title" class="text-violet-600 text-sm">Title</label>
                            <input id="title" type="text" name="title" class="w-full border border-gray-300 rounded-md transition
                                dark:bg-[rgb(255,255,255)]/20 focus:outline-none focus:ring-1
                                    focus:saturate-150 focus:ring-violet-600 dark:focus:shadow-outter-lg dark:focus:ring-transparent
                                dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30'"
                                value="{{ old('title', $kataway->title) }}"
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
                            >{{ old('description', $kataway->description) }}</textarea>

                            <x-jet-input-error for="description" class="mt-2" />

                        </div>

                        <div class="w-full lg:w-1/2 inline-flex justify-end">
                            <x-jet-button>
                                Update
                            </x-jet-button>
                        </div>
                    </div>
                </div>

                <div>
                    <div>
                        <h1 class="py-5">List of Challenges</h1>
                        @foreach ($kataway->katas as $kata)
                            <h1>{{ $kata->challenge->title }}</h1>
                        @endforeach
                    </div>

                    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                        <p>Dear {{ auth()->user()->name }}, </p>
                        <p>For community of good practice reasons, once created a Kataway, you only can update the fields in this sections.</p>
                        <p>For update or delete his selected Challenges,</p>
                        <p>you must Send Report for more information.</p>
                        <p>Regards, Katawars.</p>
                    </div>
                </div>
            </div>
        </form>


    </x-layout.wrapped-admin-sections>

</x-app-layout>
