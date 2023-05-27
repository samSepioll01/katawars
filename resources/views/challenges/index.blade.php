<x-app-layout>
    <x-layout.wrapped-main-section>

        <x-layout.searcher route="/training" />

        <main class="grid grid-cols-12 mt-8">
            <div class="grid col-span-12 sm:col-span-4 px-8">

                <div class="flex flex-col p-6">
                    <select class="select"
                            id="rank"
                            x-ref="rank"
                            x-on:change="
                                categorySelected = document.querySelector('.category-selected');

                                if (categorySelected) {
                                    categorySelected = categorySelected.firstElementChild.textContent;
                                } else {
                                    categorySelected = null;
                                }

                                axios({
                                    method: 'get',
                                    url: '/training?rank=' + $event.target.value + '&category=' + categorySelected + '&sort=' + $refs.date.value + '&status=' + $refs.status.value,
                                    responseType: 'json',
                                })
                                .then(response => {
                                    if (response.data.success) {
                                        $refs.challenges.innerHTML = response.data.challenges;
                                    }
                                })
                                .catch(error => console.log(error));
                            "
                    >
                        <option class="option" value="ranks">Ranks</option>
                        @foreach (\App\Models\Rank::all() as $rank)
                            <option class="option" value="{{ $rank->name }}">{{ ucfirst($rank->name) }}</option>
                        @endforeach
                    </select>

                    <select class="select"
                            id="date"
                            x-ref="date"
                            x-on:change="
                                categorySelected = document.querySelector('.category-selected');

                                if (categorySelected) {
                                    categorySelected = categorySelected.firstElementChild.textContent;
                                } else {
                                    categorySelected = null;
                                }

                                axios({
                                    method: 'get',
                                    url: '/training?sort=' + $event.target.value + '&rank=' + $refs.rank.value + '&category=' + categorySelected + '&status=' + $refs.status.value,
                                    responseType: 'json',
                                })
                                .then(response => {
                                    if (response.data.success) {
                                        $refs.challenges.innerHTML = response.data.challenges;
                                    }
                                })
                                .catch(error => console.log(error));
                            "
                    >
                        <option class="option" value="asc">Date</option>
                        <option class="option" value="asc">Ascendent</option>
                        <option class="option" value="desc">Descendent</option>
                    </select>

                    <select class="select"
                            id="status"
                            x-ref="status"
                            x-on:change="
                                categorySelected = document.querySelector('.category-selected');

                                if (categorySelected) {
                                    categorySelected = categorySelected.firstElementChild.textContent;
                                } else {
                                    categorySelected = null;
                                }

                                axios({
                                    method: 'get',
                                    url: '/training?status=' + $event.target.value + '&sort=' + $refs.date.value + '&rank=' + $refs.rank.value + '&category=' + categorySelected,
                                    responseType: 'json',
                                })
                                .then(response => {
                                    if (response.data.success) {
                                        $refs.challenges.innerHTML = response.data.challenges;
                                    }
                                })
                                .catch(error => console.log(error));
                            "
                    >
                        <option class="option" value="all">Status</option>
                        <option class="option" value="true">Completed</option>
                        <option class="option" value="false">Not Completed</option>
                    </select>
                </div>



            </div>
            <div class="grid col-span-12 sm:col-span-8 py-2" x-ref="challenges">
                @foreach ($challenges as $challenge)
                    <div class="card-challenge">

                        <div class="w-full flex flex-row justify-between">

                            <div class="w-full flex flex-row justify-start items-center">
                                @foreach ($challenge->categories as $category )
                                    <div class="bg-slate-50 dark:bg-slate-900 @if($selected === $category->name) category-selected bg-violet-600 dark:bg-violet-600 text-slate-100 @endif border border-slate-400 dark:border-slate-800 shadow-md hover:bg-violet-600 dark:hover:bg-violet-600 hover:text-slate-100 cursor-pointer px-2 rounded-lg mr-2">
                                        <span class="category"
                                              :class="{'category-selected': (new URLSearchParams(window.location.search)).get('category') == '{{$category->name}}' }"
                                              x-on:click="
                                                selected = $el.parentNode.classList.contains('category-selected');
                                                axios({
                                                    method: 'get',
                                                    url: '/training?category={{$category->name}}' + '&rank=' + $refs.rank.value + '&sort=' + $refs.date.value + '&selected=' + selected,
                                                    responseType: 'json',
                                                })
                                                .then(response => {
                                                    if (response.data.success) {
                                                        $refs.challenges.innerHTML = response.data.challenges;
                                                    }
                                                })
                                                .catch(error => console.log(error));
                                              "
                                        >{{ $category->name }}</span>
                                    </div>
                                @endforeach
                                <x-utilities.rank size="4" :rank="$challenge->rank->name" />
                            </div>

                            <div class=" w-full flex flex-row justify-end gap-8 item-center">
                                <x-layout.saved-marker :id="$challenge->katas->first()->id" />
                                    @if (auth()->user()->profile->passedKatas()->get()->contains($challenge->katas()->first()->id))
                                        <x-layout.favorite-button size="md" />
                                    @endif
                            </div>

                        </div>

                        <div class="py-2">
                            <a href="{{ $challenge->url }}" class="">
                                <div class="text-center text-ellipsis-1 text-xl text-violet-600 dark:text-tomato">
                                    {{ $challenge->title }}
                                </div>
                                <div class="text-ellipsis-3">
                                    <span>
                                        {!! $challenge->description !!}
                                    </span>
                                </div>
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>
        </main>

    </x-layout.wrapped-main-section>
</x-app-layout>
