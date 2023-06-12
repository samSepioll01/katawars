import _ from 'lodash';
window._ = _;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

 import Echo from 'laravel-echo';

 import Pusher from 'pusher-js';
 window.Pusher = Pusher;

 window.Echo = new Echo({
     broadcaster: 'pusher',
     key: import.meta.env.VITE_PUSHER_APP_KEY,
     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
     wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
     enabledTransports: ['ws', 'wss'],
 });


 window.PayPal.Donation.Button({
    env:'production',
    hosted_button_id:'PYNR793FU65ES',
    image: {
        src:'https://www.paypalobjects.com/en_US/ES/i/btn/btn_donateCC_LG.gif',
        alt:'Donate with PayPal button',
        title:'PayPal - The safer, easier way to pay online!',
    }
}).render('#donate-button');
