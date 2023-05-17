@props([
    'classes' => 'w-6 h-6 inline-flex rounded-full border border-slate-500 shadow-outter-sm shadow-slate-600',
    'rank' => '',
    'size' => '',
])

@php
    $ranksColor = [
        'white' => 'bg-slate-50',
        'yellow' => 'bg-yellow-600',
        'orange' => 'bg-orange-600',
        'green' => 'bg-green-600',
        'blue' => 'bg-blue-600',
        'brown' => 'bg-orange-900',
        'black' => 'bg-slate-900',
    ];

    $rank = $rank ?? 'white';
    $size = $size == 4 ? 'w-4 h-4' : 'w-6 h-6';
@endphp

<div class="{{$classes}} {{$ranksColor[$rank]}} {{$size}}"></div>
