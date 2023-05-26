@foreach ($savedKatas as $savedKata)
    <div class="card-challenge  grid grid-cols-12" id="{{ $savedKata->id }}">

        <aside class="handle cursor-grab flex justify-start items-center cols-span-1 transition-all duration-500 overflow-hidden">
            <div class="hubgrab">
                <div class="bar bg-slate-500/70 dark:bg-slate-500/70 transition-all duration-300"></div>
                <div class="bar bg-slate-500/70 dark:bg-slate-500/70 transition-all duration-300"></div>
            </div>
        </aside>

        <div class="col-span-11">
            <div class="w-full flex flex-row justify-between">
                <div class="w-full flex flex-row justify-start items-center">
                    @foreach ($savedKata->challenge->categories as $category )
                        <a href="{{ route('challenges.training') }}?category={{$category->name}}">
                            <div class="bg-slate-50 dark:bg-slate-900 border border-slate-400 dark:border-slate-800 shadow-md hover:bg-violet-600 dark:hover:bg-violet-600 hover:text-slate-100 cursor-pointer px-2 rounded-lg mr-2">
                                <span class="category">{{ $category->name }}</span>
                            </div>
                        </a>

                    @endforeach
                    <x-utilities.rank size="4" :rank="$savedKata->challenge->rank->name" />
                </div>
            </div>

            <div class="py-2">
                <a href="{{ $savedKata->challenge->url }}" class="">
                    <div class="text-center text-ellipsis-1 text-xl text-violet-600 dark:text-tomato">
                        {{ $savedKata->challenge->title }}
                    </div>
                    <div class="text-ellipsis-3">
                        <span>
                            {!! $savedKata->challenge->description !!}
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endforeach
