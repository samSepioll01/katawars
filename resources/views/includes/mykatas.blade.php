@foreach ($mykatas as $mykata)

    @php
        $challenge = $mykata->challenge;
    @endphp

    <div class="card-challenge grid grid-cols-12" id="{{ $challenge->id }}">

        <aside class="flex justify-start items-center cols-span-1 transition-all duration-500 overflow-hidden">
            <div class="hubgrab"></div>
        </aside>

        <div class="col-span-11 relative">
            <div class="w-full flex flex-row justify-between">
                <div class="w-full flex flex-row justify-start items-center">
                    @foreach ($challenge->categories as $category )
                        @php

                            $selectedCategory = request()->query('category') ?? '';
                            $isSelected = request()->query('selected') === 'true' && $selectedCategory === $category->name;
                        @endphp
                        <a href="{{ route('mykatas.index') }}?category={{$category->name}}&ord={{ request()->query('ord') }}&selected={{ request()->query('selected') == 'true' ? '' : 'true' }}">
                            <div class="bg-slate-50 dark:bg-slate-900 @if($isSelected) bg-violet-600 dark:bg-violet-600 text-slate-100  @endif border border-slate-400 dark:border-slate-800 shadow-md hover:bg-violet-600 dark:hover:bg-violet-600 hover:text-slate-100 cursor-pointer px-2 rounded-lg mr-2">
                                <span class="category">{{ $category->name }}</span>
                            </div>
                        </a>
                    @endforeach
                    <x-utilities.rank size="4" :rank="$challenge->rank->name" />
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
            <div id="{{ $challenge->id }}" class="cross-savedkata">
                <div class="cross">
                    &times;
                </div>
            </div>
        </div>
    </div>
@endforeach
<div id="next-cursor" class="hidden">
    {{ $nextCursor }}
</div>
