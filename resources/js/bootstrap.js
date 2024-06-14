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
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'ap1',
    wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
    wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
    wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});
// window.Echo = new Echo({
//     broadcaster: 'pusher',

//     key: 'd0664dccca4b6ac51c60',
//     cluster: 'ap1',
//     forceTLS: true
// });

window.Echo.channel('messages').listen('.MessageCreated', (e) => {
    console.log(1111)
    console.log(e)
});
    var channel = window.Echo.channel('messages');
    channel.listen('.MessageCreated', function(data) {
    alert(JSON.stringify(data));
});



// window.Echo.channel('messages')
//     .listen('MessageCreated', (data) => {
//         console.log('Received event:', data);
//     });

window.Echo.channel('messages')
    .listen('.MessageCreated', (e) => {
        console.log('Got event...');
        console.log(e);
    });

window.Echo.channel('messages')
.listen('.MessageCreated', (e) => {
    console.info(e);
    alert('Something happened');
    console.log(e);
});
window.Echo.channel("new-hirarc-added").listen("NewHirarcAdded", (event) => {
    console.log("camam!!");
    console.log(event);
});

// var channel1 = Echo.channel('messages');
// channe1l.listen('.MessageCreated', function(data) {
//   alert(JSON.stringify(data));
// });

// Check if channel is subscribed
// const channel1 = window.Echo.channel('messages');
// console.log('Channel:', channel1);

// // Check for events on the channel
// channel1.listen('MessageCreated', (event) => {
//     console.log('Received event:', event);
// });
