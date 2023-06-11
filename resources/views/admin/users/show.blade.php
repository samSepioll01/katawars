<x-app-layout>
    <x-layout.wrapped-admin-sections>

        <div class="flex flex-row justify-start w-1/2 py-2">
            <form action="{{ $user->deleted_at ? route('users.banned') : route('users.index') }}" method="get" class="px-5">
                <x-jet-button id="" class="w-32 flex justify-center">Back</x-jet-button>
            </form>
        </div>

        <div class="py-8 flex flex-row justify-center w-full">
            <div class="flex flex-row justify-between lg:justify-evenly px-5 w-full lg:w-1/3">
                <form action="{{ route('users.change', ['id' => $previous]) }}" method="get">
                    <x-jet-button class="w-32 flex justify-center">Previous</x-jet-button>
                </form>

                <form action="{{ route('users.change', ['id' => $next]) }}" method="get">
                    <x-jet-button id="next_btn" class="w-32 flex justify-center">Next</x-jet-button>
                </form>

            </div>
        </div>

        <div>
            <div class="flex flex-col lg:flex-row w-full justify-start items-center px-5">

                <div class="w-full flex flex-row items-center">
                    <div class="w-32 h-32 flex items-center">
                        <img class="h-32 w-32 rounded-full" src="{{ $user->profile_photo_url }}" alt="">
                    </div>

                    <div class="flex flex-col justify-center items-start w-1/2 pl-5">
                        <h1 class="text-slate-800 text-2xl w-full">
                            {{ $user->name }}
                        </h1>
                        <div class="text-sm">
                            {{ $user->email }}
                        </div>
                    </div>
                </div>

                <div class="flex flex-row justify-end lg:w-1/2 py-5">

                    <form action="{{ route('users.edit', $user) }}" method="get" class="px-5 py-2">
                        <x-jet-button id="" class="w-32 flex justify-center">Edit</x-jet-button>
                    </form>

                    @if ($user->deleted_at)
                    <form action="{{ route('users.recovery', $user) }}" method="post" class="px-5 py-2">
                        @csrf
                        <x-jet-button>Recovery</x-jet-button>
                    </form>
                    @else
                        <form action="{{ route('users.toban', $user) }}" method="post" class="px-5 py-2">
                            @csrf
                            @method('DELETE')
                            <x-jet-danger-button type="submit" class="w-32 flex justify-center">To Ban</x-jet-danger-button>
                        </form>
                    @endif

                    <form action="{{ route('users.destroy', $user) }}" method="post" class="px-5 py-2">
                        @csrf
                        @method('DELETE')
                        <x-jet-danger-button type="submit">Delete</x-jet-danger-button>
                    </form>

                </div>

            </div>



            <div class="pl-5 py-5 flex flex-col lg:flex-row w-full">

                <div class="lg:w-1/2">
                    <table class="my-10">
                        <thead class="text-gray-800 text-2xl font-semibold">
                            <tr class="">
                                <th class="font-semibold flex justify-start">User Info</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="pr-10">Email Verified At</td>
                                <td>{{ $user->email_verified_at }}</td>
                            </tr>
                            <tr>
                                <td>Bio</td>
                                <td class="max-w-lg">{{ $user->bio }}</td>
                            </tr>
                            <tr>
                                <td>Github Account</td>
                                <td>{{ $user->github_id ? 'Yes' : 'No' }}</td>
                            </tr>

                            @if ($user->github_id)
                                <tr>
                                    <tr>
                                        <td>Github URL</td>
                                        <td>{{ $user->github_url }}</td>
                                    </tr>
                                    <tr>
                                        <td>Github Repos URL</td>
                                        <td>{{ $user->github_repos_url }}</td>
                                    </tr>
                                    <tr>
                                        <td>Github Token</td>
                                        <td>{{ $user->github_token }}</td>
                                    </tr>
                                    <tr>
                                        <td>Github Expires In</td>
                                        <td>{{ $user->github_expires_in }}</td>
                                    </tr>
                                </tr>
                            @endif


                            <tr>
                                <td>Is Banned</td>
                                <td>{{ $user->deleted_at ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <td>Status Connection</td>
                                <td>
                                    <div class="flex flex-row items-center">
                                        @php
                                            $isOnline = \App\Models\User::isOnline($user);
                                        @endphp
                                        <div class="rounded-full p-1 w-4 h-4 border
                                            @if($isOnline)
                                                bg-green-600 border-green-300
                                            @else
                                                bg-rose-600 border-rose-300
                                            @endif
                                        "
                                        ></div>
                                        <div class="text-slate-800 pl-2 dark:text-slate-100 font-semibold">
                                            {{ $isOnline ? 'Online' : 'Offline' }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Two Factors Active</td>
                                <td>{{ $user->two_factor_confirmed_at ? 'Yes' : 'No' }}</td>
                            </tr>
                            @if ($user->two_factor_confirmed_at)
                                <tr>
                                    <td>Two Factor Codes</td>
                                    <td>{{ $user->two_factor_recovery_codes }}</td>
                                </tr>
                                <tr>
                                    <td>Two Factor Secret</td>
                                    <td>{{ $user->two_factor_secret }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>Created At</td>
                                <td>{{ $user->created_at }}</td>
                            </tr>
                            <tr>
                                <td>Updated At</td>
                                <td>{{ $user->updated_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <table class="my-10 lg:w-1/2">
                    <thead class="text-gray-800 text-2xl font-semibold">
                        <tr>
                            <th class="font-semibold flex justify-start">Profile Info</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="pr-10">Main Page</td>
                            <td>{{ $user->profile->url }}</td>
                        </tr>
                        <tr>
                            <td>Slug</td>
                            <td>{{ $user->profile->slug }}</td>
                        </tr>
                        <tr>
                            <td>EXP</td>
                            <td>{{ $user->profile->exp }}</td>
                        </tr>

                        <tr>
                            <td>HONOR</td>
                            <td>{{ $user->profile->honor }}</td>
                        </tr>
                        <tr>
                            <td>Dark Mode</td>
                            <td>{{ $user->profile->is_darkmode ? 'Yes' : 'No' }}</td>
                        </tr>
                        <tr>
                            <td>Rank</td>
                            <td>
                                <x-utilities.rank :size="4" rank="{{ $user->profile->rank->name }}" />
                                {{ ucwords($user->profile->rank->name) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Last Activity</td>
                            @php
                                $last = (new \Carbon\Carbon($user->profile->last_activity));
                            @endphp
                            <td>{{ $last }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{ $last->diffForHumans(now()) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="w-full py-10">
                <div class="flex flex-col lg:flex-row justify-evenly gap-4 items-start lg:items-center text-xl font-semibold">
                    <div>
                        <a href="{{ route('users.challenges', ['user' => $user]) }}">Created Challenges ({{ $user->profile->ownerKatas->count() }})</a></div>
                    <div>
                        <a href="">Created Kataways ({{ $user->profile->createdKataways->count() }})</a>
                    </div>
                    <div>
                        <a href="{{ route('users.comments', $user) }}">Comments ({{ $user->profile->comments->count() }})</a>
                    </div>
                    <div>
                        <a href="{{ route('users.resources', $user) }}">Resources Published ({{ $user->profile->publishedResources->count() }})</a>
                    </div>
                </div>

            </div>

        </div>
    </x-layout.wrapped-admin-sections>

</x-app-layout>
