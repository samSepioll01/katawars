@props(['comment'])

<div class="flex flex-col items-center w-full">
    <article class="flex w-full md:w-[70%] p-5 pb-2 px-5 bg-slate-100 dark:bg-slate-800/70 rounded-lg border border-slate-200 dark:border-slate-800/80">
        <div class="px-2">
            <div class="w-16 h-16">
                <img src="{{$comment->author->user->profile_photo_url}}" class="rounded-xl" alt="">
            </div>
        </div>
        <div class="w-full">
            <header class="py-4">
                <strong class="font-bold">{{ $comment->author->user->name }}</strong>
                <p class="text-xs">
                    Published
                    <time>{{ $comment->created_at->diffForHumans(now()) }}</time>
            </header>
            <p class="text-justify">
                {{ $comment->body }}
            </p>
        </div>

    </article>
    <div class="w-[70%] py-2 flex justify-end pr-1">
        @livewire('like-button', ['model' => $comment])
    </div>
</div>
