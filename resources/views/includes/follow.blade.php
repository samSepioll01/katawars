@if ($follows->count())
    @foreach ($follows as $follow)
        <div class="card-challenge w-full md:w-3/5 h-28">
                <div class="px-5">
                    <a href="{{ $follow->url }}">
                        <div class="flex flex-row">

                            <div class="w-full flex flex-row items-center pr-3">
                                <div class="h-20 w-20 rounded-full">
                                    <img src="{{ $follow->user->profile_photo_url }}" alt="" class="rounded-full" />
                                </div>
                                <div class="text-xl pl-3">
                                    {{ $follow->user->name }}
                                </div>
                            </div>

                            <div class="flex items-center">
                                <x-layout.new-follow-btn :profile="$follow" />
                            </div>
                        </div>
                    </a>

                </div>
        </div>
    @endforeach
@else
    <div class="mt-40">
        <h1 class="text-slate-700/70 dark:text-slate-100 text-xl font-bold">Nothing that show for the momment.</h1>
    </div>
@endif
