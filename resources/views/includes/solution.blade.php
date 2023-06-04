@vite(['resources/css/prism.css', 'resources/js/prism.js'])

@if ($challenge->katas->first()->video()->exists())
    <div class="w-full flex justify-center">
        {!! $challenge->katas->first()->video->youtube_code !!}
    </div>
@endif

<div id="contsolutions" x-ref="contsolutions" class="w-full flex flex-col items-center gap-8 pt-5 justify-center">
    @if ($solutions->count())
        @foreach ($solutions as $solution)
            <div class="w-full md:w-3/4 xl:w-1/2 relative">
                <a href="{{ $solution->profile->url }}">
                    <div class="flex flex-row items-center">
                        <div class="py-2 px-3">
                            <img class="h-10 w-10 rounded-full" src="{{ $solution->profile->user->profile_photo_url }}" alt="">
                        </div>
                        <div class="text-slate-700 dark:text-slate-100 text-sm flex flex-col items-center">
                            <div>
                                {{ $solution->profile->user->name }}
                            </div>
                            <div class="text-[11px]">
                                {{ $solution->created_at->diffForHumans(now()) }}
                            </div>

                        </div>

                    </div>
                </a>

                <div class="overflow-hidden rounded-lg">
                    <pre class="rounded-md"><code class="language-javascript">{{ trim($solution->code) }}</code></pre>
                </div>
                <div class="w-full flex flex-row justify-between">
                    <div class=" w-full flex flex-row justify-end gap-8 item-center">
                        @livewire('like-button', ['model' => $solution])
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <h1 class="text-slate-700/70 dark:text-slate-100 font-bold text-xl">Anybody completed this kata yet.</h1>
    @endif
</div>
<script>
    Prism.highlightAll();
</script>
