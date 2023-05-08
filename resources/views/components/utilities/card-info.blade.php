@props([
    'cards' => [
        'codificacion' => [
            'src' => env('AWS_APP_URL') . '/icons/codificacion.png',
            'alt' => 'Coding icon'
        ],
        'ranks' => [
            'src' => env('AWS_APP_URL') . '/icons/medalla-de-oro.png',
            'alt' => 'Rank and Honor',
        ],
        'feedback' => [
            'src' => env('AWS_APP_URL') . '/icons/interpersonales.png',
            'alt' => 'Feedback icon',
        ],
        'perspectives' => [
            'src' => env('AWS_APP_URL') . '/icons/pensamiento-critico.png',
            'alt' => 'Perspectives icon',
        ],
        'codingspeed' => [
            'src' => env('AWS_APP_URL') . '/icons/gestion-del-tiempo.png',
            'alt' => 'Coding time icon',
        ],
        'challenges' => [
            'src' => env('AWS_APP_URL') . '/icons/disputar.png',
            'alt' => 'Clashes icon',
        ],
    ],
    'card' => '',
])

<div class="card-info">
    <div class="card-info-icon">
        <img src="{{ $cards[$card]['src'] }}" alt="{{ $cards[$card]['alt'] }}">
    </div>
    <h3 class="card-info-title">{{ $title }}</h3>
    <p class="card-info-text">
        {{ $text }}
    </p>
</div>
