@props([
    'baseClasses' => 'w-full inline-flex block p-2 leading-5 text-sm tracking-wide rounded-md text-slate-800 hover:bg-gray-200
                     dark:hover:bg-slate-700 dark:hover:text-slate-300 dark:text-slate-500 transition',
    'button' => '',
])

@php
    $button = $button === 'true' ? true : false;
@endphp

@if ($button)
    <button {{ $attributes->merge(['class' => $baseClasses]) }}>
        {{ $slot }}
    </button>
@else
    <a {{ $attributes->merge(['class' => $baseClasses]) }}>
        {{ $slot }}
    </a>
@endif
