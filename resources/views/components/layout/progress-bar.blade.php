@props([
    'size' => '',
    'progress' => '',
    'title' => '',
    'sidebar' => '',
])

@php
    $sidebar = $sidebar ?? false;
    $bgColor = $sidebar ? 'dark:bg-gray-700/40' : 'dark:bg-gray-900/40';
    $textSize = $sidebar ? 'text-sm' : 'text-md';
@endphp

<div class="w-full flex flex-col justify-center md:py-0">
    @if ($title)
        <span class="dark:text-slate-200 {{ $textSize }} ">{{ $title }}</span>
    @endif

    <div class="w-full mt-2 rounded-md bg-gray-900/10 {{ $bgColor }} saturate-150"
         style="height: {{ $size }}px"
    >
        <div style="width: {{ $progress }}%" class="h-full bg-green-600 dark:bg-[#0bec7c]
                    animation-progress-bar rounded-md transition-all duration-500
                    dark:shadow-outter-md dark:shadow-green-400"
        ></div>
    </div>
</div>
