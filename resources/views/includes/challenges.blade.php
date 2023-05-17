@foreach ($challenges as $challenge)
    <div class="card-challenge">
        <div class="w-full flex flex-row justify-between">
            <div class="w-full flex flex-row justify-start items-center">
                @foreach ($challenge->categories as $category )
                    <div class="border border-slate-400 bg-slate-50 dark:bg-slate-900 @if($selected === $category->name) bg-violet-600 dark:bg-violet-600 text-slate-100 @endif dark:border-slate-800 shadow-md hover:bg-violet-600 dark:hover:bg-violet-600 hover:text-slate-100 cursor-pointer px-2 rounded-lg mr-2">
                        <span class="category"
                                x-on:click="
                                axios({
                                    method: 'get',
                                    url: '/training/{{ $category->name }}',
                                    responseType: 'json',
                                })
                                .then(response => response.data.success
                                    ? $refs.challenges.innerHTML = response.data.challenges
                                    : null
                                )
                                .catch(error => console.log(error));
                                "
                        >
                            {{ $category->name }}
                        </span>
                    </div>
                @endforeach
            </div>
            <div>
                favorite
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
