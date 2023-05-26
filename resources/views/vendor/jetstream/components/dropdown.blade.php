@props([
    'align' => 'right',
    'width' => '48',
    'contentClasses' => 'relative p-3 rounded-md border border-gray-300 dark:border-slate-800 bg-slate-50 dark:bg-gray-900',
    'dropdownClasses' => 'hidden sm:block absolute z-50 mt-4 rounded-md shadow-md overflow-hidden',
])

@php

$alignments = [
    'right' => 'origin-top-right right-0',
    'left' => 'origin-top-left left-0',
    'top' => 'origin-top',
    'none' => '',
    'false' => ''
];

$widths = [
    '48' => 'w-48', '52' => 'w-52', '56' => 'w-56', '60' => 'w-60',
    '64' => 'w-64', '72' => 'w-72', '80' => 'w-80', '96' => 'w-96',
];

$alignmentClasses = $alignments[$align];
$width = $widths[$width];

@endphp

<div
    class="relative w-fit"
    x-data="{ open: false }"
    @click.away="open = false"
    @close.stop="open = false"
    @resize.window="
            width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
            if (width < 640 && open) {
                open = false;
            }
    "
>

    <div @click="open = ! open" class="w-fit">
        {{ $trigger }}
    </div>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class=" {{ $width }} {{ $alignmentClasses }} {{ $dropdownClasses }}"
            style="display: none;"
    >
        <div
            id="dropdown-content"
            class="{{ $contentClasses }} max-h-[81vh] overflow-y-auto scrollbar-inner-menu moz-scrollbar-light dark:moz-scrollbar-dark"
        >
            {{ $content }}
        </div>
    </div>
</div>
