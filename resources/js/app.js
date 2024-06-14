import './bootstrap';

import Alpine from 'alpinejs';
import SignaturePad from 'signature_pad';

window.Alpine = Alpine;

Alpine.start();


// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js'; 
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true,
//     forceTLS: true,
// });

// window.Echo.channel('new-hirarc-added') // Listen to the default channel for NewHirarcAdded event
//     .listen('NewHirarcAdded', (event) => {
//         console.log('New HIRARC added:', event.hirarc);
//         // Handle the event (e.g., display a notification to the user)
//     });