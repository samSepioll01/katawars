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

    $isFav = auth()->user()->profile->solutions()
        ->where('kata_id', $id)->first()?->favorite
        ?->where('is_active', true)?->count();
@endphp


<div class="flex justify-between items-center">
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

                axios({
                    method: 'put',
                    url: '/favorites/' + $event.target.id,
                    responseType: 'json',
                })
                .then(response => console.log(response.data.success))
                .catch(errors => console.log(errors));
            "
            class="cursor-pointer"
        >
    </div>
</div>
