
@props([
    'type' => '',
    'colorStatus' => [
        'success' => 'bg-teal-600 border-teal-700 shadow-teal-400 text-white',
        'error' => 'bg-rose-600 border-rose-800 shadow-rose-400 text-white',
        'warning' => 'bg-yellow-500 border-yellow-700 text-orange-700',
    ],
])

@php
    $time = $type === 'error' ? 10000 : 5000;
@endphp

<div
    class="w-1/3 h-32 fixed bottom-0 flex justify-end items-center p-6 right-0"
    :class="{'hidden': session()->has('syncStatus')}"
    x-data="{ open: true }"
    x-show="open"
    x-init="setTimeout(() => open = false, {{ $time }})"
>

    <div x-show="open"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-1000"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute z-50 mt-2 rounded-md"
            style="display: none;"
    >
        <div class="{{ $colorStatus[$type] }} w-full rounded-lg py-2 px-4 text-md mr-4 font-semibold border shadow-outter-sm" role="alert">
            {{ $slot }}
        </div>
    </div>
</div>
