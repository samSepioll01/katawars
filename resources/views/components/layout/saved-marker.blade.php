@props(['id'])

@php
    $isSaved = auth()->user()->profile->savedKatas()->get()->contains($id);
@endphp


<div class="flex flex-row justify-end items-center" >
    <img
        src="
        @if ($isSaved)
            https://s3.eu-south-2.amazonaws.com/katawars.es/app/icons/marcador2.png
        @else
            https://s3.eu-south-2.amazonaws.com/katawars.es/app/icons/marcador1.png
        @endif"
        class="h-8 w-8 cursor-pointer"
        x-ref="imagemarker"
        id="{{ $id }}"
        x-on:click="
            if ($event.target.src === $katawars.S3.icons.markerOn) {
                $event.target.src = $katawars.S3.icons.markerOff;
            } else {
                $event.target.src = $katawars.S3.icons.markerOn;
            }

            axios({
                method: 'post',
                url: '/saved-katas/' + $event.target.id,
                responseType: 'json',
            })
            .then(response => console.log(response.data.success))
            .catch(errors => console.log(errors));
        "
    />

</div>
