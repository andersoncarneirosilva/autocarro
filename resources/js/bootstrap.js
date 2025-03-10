import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,  // Pega a chave do .env
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER, // Pega o cluster do .env
    wsHost: window.location.hostname,
    wsPort: 6001,  // Porta do WebSocket do Laravel
    forceTLS: false,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
});


