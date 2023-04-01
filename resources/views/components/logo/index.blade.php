@props([
    'type' => 'text',
    'logo' => [
        'icon' => 'logo7.svg',
        'text' => 'logo8.svg',
    ],
])


<div>
    <img src="{{ url("/storage/logo/$logo[$type]") }}" alt="Katawars Logo" {{ $attributes }} />
</div>
