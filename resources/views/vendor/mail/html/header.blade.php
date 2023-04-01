@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                <img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
            @else
                <img src="https://i.imgur.com/ZHBj8Iq.png" class="logo" alt="Katawars Logo">
            @endif
        </a>
    </td>
</tr>
