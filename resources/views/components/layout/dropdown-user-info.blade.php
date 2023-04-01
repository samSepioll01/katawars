<div class="flex items-center p-4 sm:p-0">

    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
        <div class="shrink-0">
            <img class="h-16 w-16 sm:h-12 sm:w-12 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                alt="{{ Auth::user()->name }}" />
        </div>
    @endif

    <div class="p-2">
        <p class="text-ellipsis-1 font-medium text-base text-slate-900 dark:text-slate-50">{{ Auth::user()->name }}</p>
        <p class="text-ellipsis-1 font-medium text-sm text-slate-500">{{ Auth::user()->email }}</p>
    </div>

</div>
