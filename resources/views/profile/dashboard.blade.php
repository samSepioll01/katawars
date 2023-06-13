<x-app-layout>
    <div class="min-h-screen py-12">
        <div class="max-w-7xl mx-auto md:px-6 lg:px-8">
            <div class="sm:rounded-lg">

                <header class="md:py-6 w-full sm:card-panel relative">

                    @if (auth()->user()->id != $userValues['id'])
                        <div class="p-10 absolute top-0 left-0 flex justify-center items-center">
                            <div class="flex items-center">
                                <x-layout.new-follow-btn :profile="\App\Models\Profile::find((int)$userValues['id'])" />
                            </div>
                        </div>
                    @endif



                    <div class="grid grid-flow-row md:grid-flow-col md:grid-cols-12 gap-4">

                        <div class="p-5 grid col-span-12 md:col-span-6 justify-items-center gap-6">

                            <div
                                class="w-44 h-44 rounded-full shadow-2xl shadow-violet-600 dark:shadow-cyan-600v"
                            >
                                <a href="{{ auth()->user()->id == $userValues['id'] ? route('profile.show') : '' }}">
                                    <img class="w-full h-full rounded-full block hover:scale-110 transition-all duration-500" src="{{ $userValues['avatar'] }}" alt="Profile Photo">
                                </a>
                            </div>

                            <div class="text-xl text-gray-600 dark:text-slate-200">
                                {{ __($userValues['nickname']) }}
                            </div>

                            <div class="w-full flex justify-evenly text-sm dark:text-slate-200">

                                <span
                                    x-on:click="
                                        axios({
                                            method: 'get',
                                            url: '{{ route('user.followers', $userValues['slug']) }}',
                                            responseType: 'json',
                                        })
                                        .then(response => {
                                            console.log(response.data.success);
                                            if (response.data.success) {
                                                target = document.getElementById('followers-modal_content');
                                                target.innerHTML = response.data.returnHTML;
                                                $modals.show('followers-modal');
                                            }

                                        })
                                        .catch(errors => console.log(errors));
                                    "
                                    class="hover:text-violet-600 trasition-colors duration-300 cursor-pointer"
                                >
                                    <span class="font-bold" @followsupdated.window="
                                        $el.textContent = $event.detail.followers;
                                    "
                                    >
                                        {{ $userValues['count_followers'] }}
                                    </span>
                                    <span class="pl-1 tracking-wide">Followers</span>
                                </span>
                                <span
                                    x-on:click="
                                        axios({
                                            method: 'get',
                                            url: '{{ route('user.following', $userValues['slug']) }}',
                                            responseType: 'json',
                                        })
                                        .then(response => {
                                            if (response.data.success) {
                                                target = document.getElementById('following-modal_content');
                                                target.innerHTML = response.data.returnHTML;
                                                $modals.show('following-modal');
                                            }
                                        })
                                        .catch(errors => console.log(errors));
                                    "
                                    class="hover:text-violet-600 trasition-colors duration-300 cursor-pointer"
                                >
                                    <span class="font-bold" @followsupdated.window="
                                        $el.textContent = $event.detail.following;
                                    "
                                >{{ $userValues['count_following'] }}</span>
                                    <span class="pl-1 tracking-wide">Following</span>
                                </span>

                            </div>

                            <div class="w-full dark:text-slate-200">
                                {{ __($userValues['bio']) }}
                            </div>

                        </div>

                        <div class="grid col-span-12 lg:col-span-6">

                            <div class="w-full grid grid-flow-row grid-row-2 p-5">

                                <div class="grid grid-flow-col grid-cols-7 gap-8 min-h-full py-2">

                                    <div class="grid col-span-4 items-center border-r border-r-gray-300 dark:border-r-slate-500 dark:text-slate-200">

                                        <div>
                                            <label class="pr-1 font-bold">Ranked:</label>
                                            <span class="">#{{ $userValues['ranking'] }}</p>
                                        </div>

                                        <div class="">
                                            <label class="pr-1 font-bold">Rank:</label>
                                            <span class="text-md">
                                                {{ __(ucfirst($userValues['rank'])) }}
                                            </span>
                                            <x-utilities.rank :rank="$userValues['rank']"/>
                                        </div>

                                        <div>
                                            <label class="pr-1 font-bold">Member Since:</label>
                                            <span class="">{{ $userValues['time_elapsed'] }}</span>
                                        </div>

                                        <div>
                                            <label class="pr-1 font-bold">Last Connection:</label>
                                            <span class="">
                                                {{ $userValues['last_activity'] }}
                                            </span>
                                        </div>

                                    </div>

                                    <div class="grid col-span-3 dark:text-slate-200">
                                        <div class="flex flex-col justify-evenly">

                                            <p><span class="font-bold">{{ number_format($userValues['exp']) }}</span><span class="pl-1">EXP</span></p>
                                            <p><span class="font-bold">{{ number_format($userValues['honor']) }}</span><span class="pl-1">HONOR</span></p>
                                        </div>

                                    </div>

                                </div>

                                <x-layout.progress-bar :progress="$userValues['progress']" size="4" title="Rank Progress" />

                            </div>

                        </div>
                    </div>
                </header>

                <main x-data="{feed: true, katas: false, kataways: false, created: false}" class="sm:mt-8 grid grid-flow-row sm:card-panel">
                    <nav class="grid grid-flow-col grid-cols-12 shadow-xl relative overflow-hidden dark:text-slate-200">
                        <div
                            class="tab col-span-3"
                            :class="{'dark:text-slate-50 text-slate-700 tracking-wider': feed}"
                            x-on:click="feed = true, katas = false, kataways = false, created = false"
                        >
                            <span class="">Feed</span>
                            <div class="tab-bottom" :class="{'tab-selected': feed}"></div>
                        </div>

                        <div
                            class="tab col-span-3"
                            :class="{'dark:text-slate-50 text-slate-700 tracking-wider': katas}"
                            x-on:click="feed = false, katas = true, kataways = false, created = false"
                        >
                            <span class="">Passed Katas</span>
                            <div class="tab-bottom" :class="{'tab-selected': katas}"></div>
                        </div>

                        <div
                            class="tab col-span-3"
                            :class="{'dark:text-slate-50 text-slate-700 tracking-wider': kataways}"
                            x-on:click="feed = false, katas = false, kataways = true, created = false"
                        >
                            <span class="">Kataways</span>
                            <div class="tab-bottom" :class="{'tab-selected': kataways}"></div>
                        </div>

                        <div
                            class="tab col-span-3"
                            :class="{'dark:text-slate-50 text-slate-700 tracking-wider': created}"
                            x-on:click="feed = false, katas = false, kataways = false, created = true"
                        >
                            <span class="">Created Katas</span>
                            <div class="tab-bottom" :class="{'tab-selected': created}"></div>
                        </div>

                    </nav>
                    <div class="min-h-screen grid grid-flow-row">
                        <div class="py-5">
                            <section x-show="feed" style="display: none;">
                                <div class="w-full lg:w-3/4 py-10 mx-auto">
                                    @if (!count($userValues['feedKatas']))
                                        <h1 class="flex items-center text-lg dark:text-slate-100 font-semibold justify-center">Your list its empty.</h1>
                                    @endif
                                    @foreach ($userValues['feedKatas'] as $kata)
                                        <div class="card-challenge relative">
                                            <div class="w-full flex flex-row justify-between">
                                                <div class="w-full flex flex-row justify-start items-center">

                                                    @foreach ($kata->challenge->categories as $category )
                                                        <div class="border border-slate-400 bg-slate-50 dark:bg-slate-900 dark:border-slate-800 shadow-md hover:bg-violet-600 dark:hover:bg-violet-600 hover:text-slate-100 cursor-pointer px-2 rounded-lg mr-2">
                                                            <span class="category">{{ $category->name }}</span>
                                                        </div>
                                                    @endforeach
                                                    <x-utilities.rank :size="4" :rank="$kata->challenge->rank->name"/>
                                                    <div class="absolute bottom-1 left-4 flex flex-row items-center">
                                                        <img src="{{ $kata->owner->user->profile_photo_url }}" class="h-6 w-6" alt="">
                                                        <span class="text-sm px-3">{{ $kata->owner->user->name }}</span>
                                                    </div>
                                                </div>

                                                <div class=" w-full flex flex-row justify-end gap-8 item-center">
                                                    @php
                                                        $id = $kata->id;
                                                    @endphp
                                                    <x-layout.saved-marker :id="$id" />
                                                        @if (auth()->user()->profile->passedKatas()->get()->contains($id))
                                                            <x-layout.favorite-button :id="$id" size="md" />
                                                        @endif
                                                </div>
                                            </div>

                                            <div class="py-2">
                                                <a href="{{ $kata->challenge->url }}" class="">
                                                    <div class="text-center text-ellipsis-1 text-xl text-violet-600 dark:text-tomato">
                                                        {{ $kata->challenge->title }}
                                                    </div>
                                                    <div class="text-ellipsis-2">
                                                        <span>
                                                            {!! $kata->challenge->description !!}
                                                        </span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </section>
                            <section x-show="katas" style="display: none;">
                                <div class="w-full lg:w-3/4 py-10 mx-auto">
                                    @if (!count($userValues['passedKatas']))
                                        <h1 class="flex items-center text-lg dark:text-slate-100 font-semibold justify-center">Your list its empty.</h1>
                                    @endif
                                    @foreach ($userValues['passedKatas'] as $kata)
                                        <div class="card-challenge">
                                            <div class="w-full flex flex-row justify-between">
                                                <div class="w-full flex flex-row justify-start items-center">
                                                    @foreach ($kata->challenge->categories as $category )
                                                        <div class="border border-slate-400 bg-slate-50 dark:bg-slate-900 dark:border-slate-800 shadow-md hover:bg-violet-600 dark:hover:bg-violet-600 hover:text-slate-100 cursor-pointer px-2 rounded-lg mr-2">
                                                            <span class="category">{{ $category->name }}</span>
                                                        </div>
                                                    @endforeach
                                                    <x-utilities.rank :size="4" :rank="$kata->challenge->rank->name"/>
                                                </div>

                                                <div class=" w-full flex flex-row justify-end gap-8 item-center">
                                                    @php
                                                        $id = $kata->id;
                                                    @endphp
                                                    <x-layout.saved-marker :id="$id" />
                                                        @if (auth()->user()->profile->passedKatas()->get()->contains($id))
                                                            <x-layout.favorite-button :id="$id" size="md" />
                                                        @endif
                                                </div>
                                            </div>

                                            <div class="py-2">
                                                <a href="{{ $kata->challenge->url }}" class="">
                                                    <div class="text-center text-ellipsis-1 text-xl text-violet-600 dark:text-tomato">
                                                        {{ $kata->challenge->title }}
                                                    </div>
                                                    <div class="text-ellipsis-3">
                                                        <span>
                                                            {!! $kata->challenge->description !!}
                                                        </span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </section>
                            <section x-show="kataways" style="display: none;">
                                <div class="w-full lg:w-3/4 py-10 mx-auto">
                                    @if (!count($userValues['kataways']))
                                        <h1 class="flex items-center text-lg dark:text-slate-100 font-semibold justify-center">Your list its empty.</h1>
                                    @endif
                                    @foreach ($userValues['kataways'] as $kataway)
                                        <div class="card-challenge relative">
                                            <div class="w-full flex flex-row gap-4">
                                                <img class="h-6 w-6" src="{{ $kataway->createdByProfile->user->profile_photo_url }}" alt="" />
                                                <span>{{ $kataway->createdByProfile->user->name }}</span>
                                            </div>
                                            <div class="border border-green rounded-lg py-1 px-2 w-fit h-fit absolute right-2 top-2 text-sm text-green-800 bg-green-200">
                                                Completed
                                            </div>

                                            <div class="py-2">
                                                <a href="{{ route('kataways.show', $kataway) }}" class="">
                                                    <div class="text-center text-ellipsis-1 text-xl text-violet-600 dark:text-tomato">
                                                        {{ $kataway->title }}
                                                    </div>
                                                    <div class="text-ellipsis-3">
                                                        <span>
                                                            {!! $kataway->description !!}
                                                        </span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                            <section x-show="created" style="display: none;">
                                <div class="w-full lg:w-3/4 py-10 mx-auto">
                                    @if (!count($userValues['createdKatas']))
                                    <h1 class="flex items-center text-lg dark:text-slate-100 font-semibold justify-center">Your list its empty.</h1>
                                    @endif
                                    @foreach ($userValues['createdKatas'] as $kata)
                                        <div class="card-challenge">
                                            <div class="w-full flex flex-row justify-between">
                                                <div class="w-full flex flex-row justify-start items-center">
                                                    @foreach ($kata->challenge->categories as $category )
                                                        <div class="border border-slate-400 bg-slate-50 dark:bg-slate-900 dark:border-slate-800 shadow-md hover:bg-violet-600 dark:hover:bg-violet-600 hover:text-slate-100 cursor-pointer px-2 rounded-lg mr-2">
                                                            <span class="category">{{ $category->name }}</span>
                                                        </div>
                                                    @endforeach
                                                    <x-utilities.rank :size="4" :rank="$kata->challenge->rank->name"/>
                                                </div>

                                                <div class=" w-full flex flex-row justify-end gap-8 item-center">
                                                    @php
                                                        $id = $kata->id;
                                                    @endphp
                                                    <x-layout.saved-marker :id="$id" />
                                                        @if (auth()->user()->profile->passedKatas()->get()->contains($id))
                                                            <x-layout.favorite-button :id="$id" size="md" />
                                                        @endif
                                                </div>
                                            </div>

                                            <div class="py-2">
                                                <a href="{{ $kata->challenge->url }}" class="">
                                                    <div class="text-center text-ellipsis-1 text-xl text-violet-600 dark:text-tomato">
                                                        {{ $kata->challenge->title }}
                                                    </div>
                                                    <div class="text-ellipsis-3">
                                                        <span>
                                                            {!! $kata->challenge->description !!}
                                                        </span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                        </div>
                    </div>
                </main>
            </div>
            <x-layout.modal name="followers-modal" maxWidth="4xl" display="justify-start">

                <x-slot name="title">
                    <div class="cross-savedkata opacity-100" x-on:click="show = false;">
                        <div class="cross" x-on:click="show = false;">
                            &times;
                        </div>
                    </div>
                    <div class="text-6xl font-thin text-center text-slate-700/90 dark:text-slate-100 pb-5">
                        Followers
                    </div>
                </x-slot>

                <x-slot name="body">
                    <div id="followers-modal_content" class="flex flex-col justify-center items-center text-slate-800"></div>
                </x-slot>

                <x-slot name="footer"></x-slot>
            </x-layout.modal>

            <x-layout.modal name="following-modal" maxWidth="4xl" display="justify-start">

                <x-slot name="title">
                    <div class="cross-savedkata opacity-100" x-on:click="show = false;">
                        <div class="cross" x-on:click="show = false;">
                            &times;
                        </div>
                    </div>

                    <div class="text-6xl font-thin text-center text-slate-700/90 dark:text-slate-100 pb-5 relative">
                        Following
                    </div>
                </x-slot>

                <x-slot name="body">
                    <div id="following-modal_content" class="flex flex-col justify-center items-center text-slate-800"></div>
                </x-slot>

                <x-slot name="footer"></x-slot>
            </x-layout.modal>
        </div>
    </div>
</x-app-layout>
