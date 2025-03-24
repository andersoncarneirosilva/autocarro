// DESENVOLVIMENTO
// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';

// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: window.location.hostname,
//     wsPort: 6001,
//     wssPort: 6001,
//     forceTLS: false,
//     disableStats: true,
//     enabledTransports: ['ws'],
// });

// console.log("Instância de Echo criada com sucesso!");

// window.Echo.connector.pusher.connection.bind('state_change', function(states) {
//     console.log("Estado da conexão Pusher:", states);
//     if (states.current === 'connected') {
//         console.log("Conexão Pusher estabelecida com sucesso!");
//     }
// });


// PRODUCAO
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;
window.Pusher.logToConsole = true; // Isso permite visualizar os logs do Pusher no console
window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT,
    wssPort: import.meta.env.VITE_REVERB_PORT,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

window.Echo.connector.pusher.connection.bind('state_change', function(states) {
    console.log('Pusher state changed:', states);
    if (states.current === 'connected') {
        console.log('Conexão Pusher estabelecida com sucesso!');
    }
});

