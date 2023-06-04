@props(['comment', 'challenge', 'reply' => ''])

<div class="flex flex-col items-center {{ $reply ? 'w-[80%] md:w-[50%]' : 'w-full md:w-[70%]' }} relative" class="cont-comment">
    <article class="flex w-full relative p-5 pb-2 px-5 bg-slate-100 dark:bg-slate-800/70 rounded-lg border border-slate-200 dark:border-slate-800/80">
        <div class="px-2">
            <div class="w-16 h-16">
                <img src="{{$comment->author->user->profile_photo_url}}" class="rounded-xl" alt="">
            </div>
        </div>
        <div class="w-full relative">
            <header class="py-4">
                <strong class="font-bold">{{ $comment->author->user->name }}</strong>
                <p class="text-xs">
                    Published
                    <time>{{ $comment->created_at->diffForHumans(now()) }}</time>
            </header>
            <p class="text-justify w-[90%] pb-3" id="comment-body-{{$comment->id}}">
                {{ $comment->body }}
            </p>
        </div>
        <div class="absolute left-6 bottom-0 w-full py-2 flex justify-start pl-1">
            @livewire('like-button', ['model' => $comment])
        </div>
    </article>

    @can ('update', $comment)
        <div class="absolute right-2 bottom-1">
            <x-jet-button :button="true" x-on:click="
                axios({
                    method: 'get',
                    url: '{{ route('katas.comment.edit', ['challenge' => $challenge, 'comment' => $comment]) }}',
                    responseType: 'json',
                })
                .then(response => {
                    if (response.data.success) {
                        console.log(response.data.action);
                        dispatchEvent(
                            new CustomEvent('editcomment', {
                                detail: {
                                    body: response.data.body,
                                    action: response.data.action,
                                },
                            })
                        );
                    }
                })
                .catch(errors => console.log(errors));
                $modals.show('edit-comment-modal');
            "
            >
                Edit
            </x-jet-button>
        </div>

    @else

        @unless ($comment->parent_id)
            <div class="absolute right-2 bottom-1">
                <x-jet-button :button="true" id="reply-{{$comment->id}}"
                    x-on:click="
                        dispatchEvent(
                            new CustomEvent('replycomment', {
                                detail: {
                                    parent_id: $el.id.split('-')[1],
                                },
                            })
                        );
                        $modals.show('create-reply-comment-modal')
                "
                >
                    Reply
                </x-jet-button>
            </div>
        @endunless

    @endif

    @can ('delete', $comment)
        <form action="{{ route('katas.comment.destroy', ['challenge' => $challenge, 'comment' => $comment]) }}" method="post" class="cross-savedkata opacity-100 right-2 top-2">
            @csrf
            @method('DELETE')
            <button type="submit" class="cross">
                &times;
            </button>
        </form>
    @endif
</div>

{{-- Modals Page --}}


<x-layout.modal name="edit-comment-modal" maxWidth="xl" display="justify-center" heigth="h-fit">
    <x-slot name="title">
        <div class="py-4 text-center">
            Edit Resource
        </div>
        <div class="cross-menu" @click.prevent="show = false; ">
            &times;
        </div>
    </x-slot>

    <x-slot name="body">
        <form id="edit-comment-form" x-ref="edit-comment-form" action="" method="post" class="flex flex-col justify-between items-center"
            @editcomment.window="$el.action = $event.detail.action"
        >
            @csrf
            @method('PATCH')

            <div class="w-3/4 py-5">

                <div class="px-2 flex flex-row items-center justify-start py-4">
                    <div class="w-16 h-16">
                        <img src="{{auth()->user()->profile_photo_url}}" class="rounded-xl" alt="">
                    </div>
                    <div class="px-3">
                        {{ auth()->user()->name }}
                    </div>
                </div>

                <x-jet-label for="body" value="{{ __('Comment') }}" />
                <textarea name="editcommentbody" id="editcommentbody" x-ref="editcommentbody" type="editcommentbody" cols="30" rows="5" maxlength="250"
                          class="w-full block mt-1 rounded-md transition border border-gray-300 text-slate-700/70
                                dark:bg-[rgb(255,255,255)]/20 dark:text-slate-100
                                focus:outline-none focus:ring-1 focus:saturate-150 focus:ring-violet-600
                                dark:focus:shadow-outter-lg dark:focus:ring-transparent
                                dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30"
                                @editcomment.window="
                                    $el.value = $event.detail.body;
                                "
                ></textarea>
                <x-jet-input-error for="editcommentbody" class="mt-2" id="edit-error-body"/>
                <p id="edit-error-body" class="text-sm text-red-600"></p>

            </div>

            <div class="w-full flex justify-end items-center py-5 pr-5">
                <x-jet-button id="update-comment" x-ref="updatecommentbtn">
                    Update
                </x-jet-button>
            </div>


        </form>

    </x-slot>

    <x-slot name="footer"></x-slot>
</x-layout.modal>

<x-layout.modal name="create-reply-comment-modal" maxWidth="xl" display="justify-center" heigth="h-fit">
    <x-slot name="title">
        <div class="py-4 text-center">
            Reply Comment
        </div>
        <div class="cross-menu" @click.prevent="show = false; ">
            &times;
        </div>
    </x-slot>

    <x-slot name="body">
        <form id="create-reply-comment-form" x-ref="create-relpy-comment-form" action="{{ route('katas.comment.store', ['challenge' => $challenge, 'comment' => $comment]) }}" method="post" class="flex flex-col justify-between items-center">
            @csrf

            <div class="w-3/4 py-5">

                <div class="px-2 flex flex-row items-center justify-start py-4">
                    <div class="w-16 h-16">
                        <img src="{{auth()->user()->profile_photo_url}}" class="rounded-xl" alt="">
                    </div>
                    <div class="px-3">
                        {{ auth()->user()->name }}
                    </div>
                </div>

                <x-jet-label for="body" value="{{ __('Comment') }}" />
                <textarea name="body" id="replycommentbody" x-ref="replycommentbody" type="body" cols="30" rows="5" maxlength="250"
                          class="w-full block mt-1 rounded-md transition border border-gray-300 text-slate-700/70
                                dark:bg-[rgb(255,255,255)]/20 dark:text-slate-100
                                focus:outline-none focus:ring-1 focus:saturate-150 focus:ring-violet-600
                                dark:focus:shadow-outter-lg dark:focus:ring-transparent
                                dark:focus:border-cyan-300 dark:focus:shadow-cyan-700 dark:focus:bg-[rgb(255,255,255)]/30"
                ></textarea>
                <input type="hidden" name="parent_id" value=""
                    @replycomment.window="$el.value = $event.detail.parent_id">
                <x-jet-input-error for="replycommentbody" class="mt-2" id="reply-error-body"/>
                <p id="reply-error-body" class="text-sm text-red-600"></p>

            </div>

            <div class="w-full flex justify-end items-center py-5 pr-5">
                <x-jet-button id="reply-comment" x-ref="replycommentbtn">
                    {{ __('REPLY') }}
                </x-jet-button>
            </div>

        </form>

    </x-slot>

    <x-slot name="footer"></x-slot>
</x-layout.modal>
