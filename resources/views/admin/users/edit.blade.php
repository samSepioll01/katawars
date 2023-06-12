<x-app-layout>
    <x-layout.wrapped-admin-sections>

        <div class="flex flex-row justify-start w-1/2 py-2">
            <form action="{{ route('users.show', $user) }}" method="get" class="px-5">
                <x-jet-button id="" class="w-32 flex justify-center">Back</x-jet-button>
            </form>
        </div>

        <div class="w-full p-8 flex justify-center items center">
            <h1 class="text-2xl font-semibold">Edit User</h1>
        </div>

        <div class="pl-5">
            <div class="">
                <h1 class="text-xl font-semibold">Active Photo</h1>
            </div>

            <a href="{{ $user->profile->url }}">
                <div class="flex flex-row items-center">
                    <div>
                        <img src="{{ $user->profile_photo_url }}" alt="" class="rounded-full h-32 w-32">
                    </div>
                    <div class="pl-5">
                        <h3 class="text-xl">{{ $user->name }}</h3>
                        <h3 class="text-sm">{{ $user->email }}</h3>
                    </div>
                </div>
            </a>

            <div>
                <h1 class="text-xl font-semibold py-3">S3 Profile Photos</h1>
                <div class="flex flex-col lg:flex-row gap-4">
                    @foreach ($profilePhotos as $photo)
                        <div class="flex flex-row md:flex-col justify-center items-center">
                            <img class="w-32 h-32 rounded-lg" src="{{ $photo }}" alt="">
                            <form action="{{ route('users.delete.photo', ['user' => $user, 'index' => $profilePhotos->search($photo)]) }}" method="post" class="w-full flex justify-center items-center py-3">
                                @csrf
                                <x-jet-button>Delete</x-jet-button>
                            </form>
                        </div>

                    @endforeach
                </div>
            </div>

            <section class="py-10">
                <h1 class="text-2xl font-semibold pb-5">Profile Information</h1>
                <form action="{{ route('users.update', $user) }}" method="post">
                    @csrf
                    @method('PATCH')



                    <div class="w-full flex flex-row justify-center items-center">

                        <div class="w-full xl:w-3/4 flex flex-col gap-8">


                            <div class="flex flex-row justify-start">
                                <div class="">
                                    <label for="rank" class="text-violet-600 text-sm pr-2">Rank</label>
                                    <select class="admin-select" id="rank" name="rank">
                                        @foreach (\App\Models\Rank::all() as $rank)
                                            <option class="option" value="{{ $rank->name }}"
                                                @if ($user->profile->rank->id === $rank->id)
                                                    selected
                                                @endif
                                            >
                                                {{ ucfirst($rank->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="pl-20">
                                    <label for="role" class="text-violet-600 text-sm pr-2">Role</label>
                                    <select class="admin-select" id="role" name="role">
                                        @foreach (\Spatie\Permission\Models\Role::all() as $role)
                                            <option class="option" value="{{ $role->name }}"
                                                @if ($user->roles->first()->id === $role->id)
                                                    selected
                                                @endif
                                            >
                                                {{ ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="w-full xl:w-1/2">
                                <label for="name" class="text-violet-600 text-sm">Name</label>
                                <input id="name" type="text" name="name" class="w-full border border-gray-300 rounded-md transition
                                    dark:bg-[rgb(255,255,255)]/20 focus:outline-none focus:ring-1
                                      focus:saturate-150 focus:ring-violet-600 dark:focus:shadow-outter-lg dark:focus:ring-transparent
                                    dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30'"
                                    value="{{ old('name', $user->name) }}"
                                >
                                <x-jet-input-error for="name" class="mt-2" />
                            </div>

                            <div class="w-full xl:w-1/2">
                                <label for="email" class="text-violet-600 text-sm">Email</label>
                                <input id="email" name="email" type="text" class="w-full border border-gray-300 rounded-md transition
                                    dark:bg-[rgb(255,255,255)]/20 focus:outline-none focus:ring-1
                                      focus:saturate-150 focus:ring-violet-600 dark:focus:shadow-outter-lg dark:focus:ring-transparent
                                    dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30'"
                                    value="{{ old('email', $user->email) }}"
                                >
                                <x-jet-input-error for="email" class="mt-2" />
                            </div>
                            <div class="w-full xl:w-1/2">
                                <label for="bio" class="text-violet-600 text-sm">Bio</label>

                                <textarea name="bio" id="bio" type="bio" cols="30" rows="5"
                                    class="w-full block mt-1 rounded-md transition border border-gray-300
                                         dark:bg-[rgb(255,255,255)]/20 focus:outline-none focus:ring-1 focus:saturate-150 focus:ring-violet-600
                                           dark:focus:shadow-outter-lg dark:focus:ring-transparent
                                         dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30"
                                >{{ old('bio', $user->bio) }}</textarea>

                                <x-jet-input-error for="bio" class="mt-2" />

                            </div>

                            <div class="w-full xl:w-1/2">
                                <label for="honor" class="text-violet-600 text-sm">Honor</label>
                                <input id="honor" name="honor" type="text" class="w-full border border-gray-300 rounded-md transition
                                    dark:bg-[rgb(255,255,255)]/20 focus:outline-none focus:ring-1
                                      focus:saturate-150 focus:ring-violet-600 dark:focus:shadow-outter-lg dark:focus:ring-transparent
                                    dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30'"
                                    value="{{ old('honor', $user->profile->honor) }}"
                                >
                                <x-jet-input-error for="honor" class="mt-2" />
                            </div>

                            <div>
                                <x-jet-button>Update</x-jet-button>
                            </div>

                        </div>
                    </div>
                </form>
            </section>
        </div>


    </x-layout.wrapped-admin-sections>
</x-app-layout>
