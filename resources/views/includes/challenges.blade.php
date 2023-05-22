@foreach ($challenges as $challenge)
    <div class="card-challenge">
        <div class="w-full flex flex-row justify-between">
            <div class="w-full flex flex-row justify-start items-center">
                @foreach ($challenge->categories as $category )
                    <div class="border border-slate-400 bg-slate-50 dark:bg-slate-900 @if($selected === $category->name) category-selected bg-violet-600 dark:bg-violet-600 text-slate-100 @endif dark:border-slate-800 shadow-md hover:bg-violet-600 dark:hover:bg-violet-600 hover:text-slate-100 cursor-pointer px-2 rounded-lg mr-2">
                        <span class="category"
                                x-on:click="
                                selected = $el.parentNode.classList.contains('category-selected');

                                axios({
                                    method: 'get',
                                    url: '/training?category={{ $category->name }}&rank=' + $refs.rank.value + '&selected=' + selected + '&sort=' + $refs.date.value + '&status=' + $refs.status.value,
                                    responseType: 'json',
                                })
                                .then(response => response.data.success
                                    ? $refs.challenges.innerHTML = response.data.challenges
                                    : null
                                )
                                .catch(error => console.log(error));
                                "
                        >{{ $category->name }}</span>
                    </div>
                @endforeach
                <x-utilities.rank :size="4" :rank="$challenge->rank->name"/>
            </div>

            @php
                $isSaved = auth()->user()->profile->savedKatas()->exists($challenge->katas->first()->id);
            @endphp

            <div class="w-56 flex flex-row justify-evenly items-center">
                <div class="w-56 flex flex-row justify-end items-center" >
                    <img
                        src="
                        @if ($isSaved)
                            https://s3.eu-south-2.amazonaws.com/katawars.es/app/icons/marcador2.png
                        @else
                            https://s3.eu-south-2.amazonaws.com/katawars.es/app/icons/marcador1.png
                        @endif"
                        class="h-8 w-8 cursor-pointer"
                        x-ref="imagemarker"
                        x-on:click="
                            if ($event.target.src === $katawars.S3.icons.markerOn) {
                                $event.target.src = $katawars.S3.icons.markerOff;
                            } else {
                                $event.target.src = $katawars.S3.icons.markerOn;
                            }
                        "
                    />

                </div>
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
