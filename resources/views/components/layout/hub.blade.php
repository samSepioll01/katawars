@props(['responsive' => ''])

@php
    $responsive = $responsive ? 'responsive': '';
@endphp

<div {{$attributes->merge(['class' => 'hub-cont'])}}>
    <button
        @if($responsive)
            @click="responsiveOpen = ! responsiveOpen, checkHub($event.target, responsiveOpen)"
        @else
            @click="sidebarOpen = ! sidebarOpen, checkHub($event.target, sidebarOpen)"
        @endif
        class="hub {{$responsive}}"
    >
        <div class="hub-bar {{$responsive}}"></div>
        <div class="hub-bar {{$responsive}}"></div>
        <div class="hub-bar {{$responsive}}"></div>
    </button>
</div>
