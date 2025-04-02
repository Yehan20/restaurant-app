import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '805813c25c1cff4a08f4',
    cluster: 'ap2',
    forceTLS: true,
    encrypted: true,
    enabledTransports: ['ws', 'wss'],
});



