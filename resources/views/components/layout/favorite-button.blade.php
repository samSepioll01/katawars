@props([
    'id' => '',
    'size' => '',
])

@php

    $size = [
        'md' => 'w-8 h-8',
        'lg' => 'w-12 h-12',
        'xl' => 'w-16 h-16',
        '2xl' => 'w-20 h-20',
    ][$size ?? 'lg'];

    $isFav = auth()->user()->profile->favorites()->get()->contains($id)
@endphp


<div class="w-1/2 flex justify-between">
    <div class="{{ $size }}">
        <img
            src="
                @if ($isFav)
                    https://s3.eu-south-2.amazonaws.com/katawars.es/app/icons/favoritos2.png
                @else
                    https://s3.eu-south-2.amazonaws.com/katawars.es/app/icons/favoritos1.png
                @endif
            "
            x-ref="imagemarker"
            id="{{ $id }}"
            x-on:click="
                if ($event.target.src === $katawars.S3.icons.favoritesOn) {
                    $event.target.src = $katawars.S3.icons.favoritesOff;
                } else {
                    $event.target.src = $katawars.S3.icons.favoritesOn;
                }
                console.log($event.target.id);
            "
            class="cursor-pointer"
        >
    </div>
</div>