<x-app-layout>

    <x-layout.wrapped-admin-sections>
        <header>
            <div class="flex flex-row justify-start w-1/2 py-2">
                <form action="{{ route('users.index') }}" method="get" class="px-5">
                    <x-jet-button id="" class="w-32 flex justify-center">Back</x-jet-button>
                </form>
            </div>

            <div class="flex justify-center items-center">
                <h1 class="text-3xl font-semibold">Create User</h1>
            </div>
        </header>
        <main class="">
            <form action="{{ route('users.store') }}" method="post">
                @csrf
                <div class="">
                    <div class="w-full pt-10">
                        <label for="role" class="text-violet-600 text-sm pr-2">Role</label>
                        <select class="admin-select" id="role" name="role">
                            @foreach (\Spatie\Permission\Models\Role::all() as $role)
                                <option class="" value="{{ $role->name }}" @if($role->name === 'superadmin') selected @endif>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-12 gap-8">
                        <div class="col-span-12 md:col-span-5">
                            <label for="name" class="text-violet-600 text-sm">Name</label>
                            <input id="name" type="text" name="name" class="w-full border border-gray-300 rounded-md transition
                                dark:bg-[rgb(255,255,255)]/20 focus:outline-none focus:ring-1
                                    focus:saturate-150 focus:ring-violet-600 dark:focus:shadow-outter-lg dark:focus:ring-transparent
                                dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30'"
                                value="{{ old('name') }}"
                            >
                            <x-jet-input-error for="name" class="mt-2" />
                        </div>

                        <div class="col-span-12 md:col-span-5">
                            <label for="email" class="text-violet-600 text-sm">Email</label>
                            <input id="email" name="email" type="text" class="w-full border border-gray-300 rounded-md transition
                                dark:bg-[rgb(255,255,255)]/20 focus:outline-none focus:ring-1
                                    focus:saturate-150 focus:ring-violet-600 dark:focus:shadow-outter-lg dark:focus:ring-transparent
                                dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30'"
                                value="{{ old('email') }}"
                            >
                            <x-jet-input-error for="email" class="mt-2" />
                        </div>

                        <div class="col-span-12 md:col-span-5">
                            <label for="bio" class="text-violet-600 text-sm">Bio</label>

                            <textarea name="bio" id="bio" type="bio" cols="30" rows="6"
                                class="w-full block mt-1 rounded-md transition border border-gray-300
                                        dark:bg-[rgb(255,255,255)]/20 focus:outline-none focus:ring-1 focus:saturate-150 focus:ring-violet-600
                                        dark:focus:shadow-outter-lg dark:focus:ring-transparent
                                        dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30"
                            >{{ old('bio') }}</textarea>

                            <x-jet-input-error for="bio" class="mt-2" />

                        </div>

                        <div class="grid col-span-6 lg:col-span-3 gap-8 py-1">
                            <div class="col-span-6 lg:col-span-3">
                                <label for="exp" class="text-violet-600 text-sm">Exp</label>
                                <input id="exp" name="exp" type="text" class="w-full border border-gray-300 rounded-md transition
                                    dark:bg-[rgb(255,255,255)]/20 focus:outline-none focus:ring-1
                                        focus:saturate-150 focus:ring-violet-600 dark:focus:shadow-outter-lg dark:focus:ring-transparent
                                    dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30'"
                                    value="{{ old('exp') }}"
                                >
                                <x-jet-input-error for="exp" class="mt-2" />
                            </div>

                            <div class="col-span-6 lg:col-span-3">
                                <label for="honor" class="text-violet-600 text-sm">Honor</label>
                                <input id="honor" name="honor" type="text" class="w-full border border-gray-300 rounded-md transition
                                    dark:bg-[rgb(255,255,255)]/20 focus:outline-none focus:ring-1
                                        focus:saturate-150 focus:ring-violet-600 dark:focus:shadow-outter-lg dark:focus:ring-transparent
                                    dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30'"
                                    value="{{ old('honor') }}"
                                >
                                <x-jet-input-error for="honor" class="mt-2" />
                            </div>
                        </div>


                    </div>

                    <div class="flex justify-start w-full lg:w-1/2 pt-10">
                        <label for="rank" class="text-violet-600 text-sm pr-2">Rank</label>
                        <select class="admin-select" id="rank" name="rank">
                            @foreach (\App\Models\Rank::all() as $rank)
                                <option class="" value="{{ $rank->name }}" @if($rank->name === 'white') selected @endif>
                                    {{ ucfirst($rank->name) }}
                                </option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="rank" class="mt-2" />
                    </div>

                    <div class="py-10 flex justify-center w-full">
                        <x-jet-button>Create</x-jet-button>
                    </div>
                </div>
            </form>
        </main>
    </x-layout.wrapped-admin-sections>

</x-app-layout>
