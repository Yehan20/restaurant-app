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

let channel = window.Echo.channel('order-channel');

channel.listen('.order-status-update', (event) => {
    console.log('Order status updated:', event.message);
    // Update the UI or handle the data accordingly
    if (window.location.pathname === '/orders') {
        loadOrders()
        showSuccessMessage('Order status updated')

    }

}
);


