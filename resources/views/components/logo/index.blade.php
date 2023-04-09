@props([
    'type' => 'text',
    'logo' => [
        'icon' => 'logo7.png',
        'text' => 'logo8.png',
    ],
])

<div>
    <img src="{{ url("/storage/logo/$logo[$type]") }}" alt="Katawars Logo" {{ $attributes }} />
</div>
