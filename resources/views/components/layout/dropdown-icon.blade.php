@props([
    'icons' => [
        'profile' => url('/storage/icons/casa.png'),
        'statistics' => url('/storage/icons/estadisticas2.png'),
        'messages' => url('/storage/icons/mensajes1.png'),
        'orders' => url('/storage/icons/order14.png'),
        'settings' => url('/storage/icons/configuracion2.png'),
        'idioms' => url('/storage/icons/chat.png'),
        'donate' => url('/storage/icons/donate6.png'),
        'help' => url('/storage/icons/help4.png'),
        'send-reports' => url('/storage/icons/info.png'),
        'logout' => url('/storage/icons/logout2.png'),
        'dojo' => url('/storage/icons/sidebar/dojo3.png'),
        'training' => url('/storage/icons/sidebar/ala-chun1.png'),
        'blitz' => url('/storage/icons/sidebar/katana.png'),
        'kata-ways' => url('/storage/icons/sidebar/puerta-torii2.png'),
        'kumite' => url('/storage/icons/sidebar/espadas2.png'),
        'my-katas' => url('/storage/icons/sidebar/yin-yang1.png'),
        'saved-katas' => url('/storage/icons/sidebar/marcador2.png'),
        'favorites' => url('/storage/icons/sidebar/favoritos2.png'),
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
