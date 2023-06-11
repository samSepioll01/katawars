<x-app-layout>
    <div>
        <div class="bg-white dark:bg-slate-800/70 p-8 rounded-md w-full shadow-xl">
            <div>
                <h3 class="text-gray-800 dark:text-slate-100 text-2xl font-semibold">Users</h3>
            </div>

            <div class=" flex items-center justify-between pb-6">

                <div>
                    @if (request()->routeIs('users.banned'))
                        <div class="flex flex-row justify-start py-5">
                            <form action="{{ route('users.index') }}" method="get" class="">
                                <x-jet-button id="" class="w-32 flex justify-center">Back</x-jet-button>
                            </form>
                        </div>
                    @endif
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex bg-gray-50 items-center p-2 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                        <input class="bg-gray-50 outline-none ml-1 block " type="text" name="" id="" placeholder="Search...">
                    </div>

                        <div class="lg:ml-40 ml-10 space-x-8 flex flex-row">

                            @if (request()->routeIs('users.index'))
                                <form action="{{ route('users.banned') }}" method="get">
                                    <x-jet-button>Banned Users</x-jet-button>
                                </form>

                                <form action="{{ route('users.create') }}" method="">
                                    <x-jet-button>Create</x-jet-button>
                                </form>
                            @endif

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
                                            Role
                                        </th>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            email
                                        </th>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                             rank
                                        </th>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Created at
                                        </th>

                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Last Activity
                                        </th>

                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Status
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($users as $user )
                                        <tr>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <a href="{{ route('users.show', $user) }}">
                                                    <div class="flex flex-row items-center">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 w-10 h-10">
                                                                <img class="w-full h-full rounded-full"
                                                                    src="{{ $user->profile_photo_url }}"
                                                                    alt="" />
                                                            </div>
                                                            <div class="ml-3">
                                                                <p class="text-gray-900 whitespace-no-wrap">
                                                                    {{ $user->name }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <p
                                                    class="text-gray-900 whitespace-no-wrap
                                                        @if($user->roles->first()->name === 'superadmin')
                                                            rounded-lg w-fit p-1 bg-violet-600 text-slate-50 font-bold
                                                        @endif
                                                    "
                                                >
                                                    {{ ucwords($user->roles->first()->name) }}
                                                </p>
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{ $user->email }}
                                                </p>
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <div class="flex items-center">
                                                    <x-utilities.rank :size="4" rank="{{ $user->profile->rank->name }}" />
                                                    <span class="px-2 text-gray-900 whitespace-no-wrap">
                                                        {{ ucwords($user->profile->rank->name) }}
                                                    </span>
                                                </div>

                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <span>{{ $user->created_at }}</span>
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <span>{{ (new \Carbon\Carbon($user->profile->last_activity))->diffForHumans(now()) }}</span>
                                            </td>

                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <span
                                                    class="relative inline-block px-3 py-1 font-semibold leading-tight">
                                                    <span
                                                        aria-hidden
                                                        class="absolute inset-0  opacity-50 rounded-full
                                                            @if (\App\Models\User::isOnline($user))
                                                                bg-green-200
                                                            @else
                                                                bg-rose-400
                                                            @endif
                                                        "
                                                    >
                                                    </span>
                                                <span class="relative
                                                    @if (\App\Models\User::isOnline($user))
                                                        text-green-900
                                                    @else
                                                        text-red-600
                                                    @endif
                                                "
                                                >
                                                    {{ \App\Models\User::isOnline($user) ? 'Online' : 'Offline' }}
                                                </span>
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
                                {{ $users->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
    </div>
</x-app-layout>
