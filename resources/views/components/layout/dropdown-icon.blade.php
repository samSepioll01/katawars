@props([
    'icons' => [
        'profile' => env('AWS_APP_URL') . '/icons/casa.png',
        'statistics' => env('AWS_APP_URL') . '/icons/estadisticas2.png',
        'messages' => env('AWS_APP_URL') . '/icons/mensajes1.png',
        'orders' => env('AWS_APP_URL') . '/icons/order14.png',
        'settings' => env('AWS_APP_URL') . '/icons/configuracion2.png',
        'idioms' => env('AWS_APP_URL') . '/icons/chat.png',
        'donate' => env('AWS_APP_URL') . '/icons/donate6.png',
        'help' => env('AWS_APP_URL') . '/icons/help4.png',
        'send-reports' => env('AWS_APP_URL') . '/icons/info.png',
        'logout' => env('AWS_APP_URL') . '/icons/logout2.png',
        'dojo' => env('AWS_APP_URL') . '/icons/dojo3.png',
        'training' => env('AWS_APP_URL') . '/icons/ala-chun1.png',
        'blitz' => env('AWS_APP_URL') . '/icons/katana.png',
        'kata-ways' => env('AWS_APP_URL') . '/icons/puerta-torii2.png',
        'kumite' => env('AWS_APP_URL') . '/icons/espadas2.png',
        'my-katas' => env('AWS_APP_URL') . '/icons/yin-yang1.png',
        'saved-katas' => env('AWS_APP_URL') . '/icons/marcador2.png',
        'favorites' => env('AWS_APP_URL') . '/icons/favoritos2.png',
    ],
    'srcPath' => '',
    'sidebar' => '',
])

@php
    $sidebar = $sidebar ? true : false;
    $width = $sidebar ? 'w-8' : 'w-5';
@endphp

<div {{ $attributes->merge(['class' => 'pr-2']) }}>
    <img class="{{ $width }}" src="{{ $icons[$srcPath] }}" alt="Dropdown Icons"/>
</div>
