<div class="md:col-span-1 flex justify-between">
    <div class="px-4 sm:px-0">
        <h3 class="text-lg font-medium text-violet-700 dark:text-slate-100 tracking-wide">{{ $title }}</h3>

        <p class="mt-1 text-sm text-gray-600 dark:text-slate-400">
            {{ $description }}
        </p>
    </div>

    <div class="px-4 sm:px-0">
        {{ $aside ?? '' }}
    </div>
</div>
