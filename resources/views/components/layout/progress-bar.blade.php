@props([
    'size' => '',
    'progress' => '',
    'title' => '',
])

<div class="w-full flex flex-col justify-center py-10 md:py-0">
    @if ($title)
        <span class="dark:text-slate-200 py-2">{{ $title }}</span>
    @endif

    <div class="w-full rounded-md bg-gray-900/10 dark:bg-gray-900/10 saturate-150
                dark:shadow-outter-md dark:shadow-green-400"
         style="height: {{ $size }}px"
    >
        <div style="width: {{ $progress }}%" class="h-full bg-green-600 dark:bg-[#0bec7c]
                    animation-progress-bar rounded-md transition-all duration-500"
        ></div>
    </div>
</div>
