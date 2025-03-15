// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';

// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,  // Pega a chave do .env
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER, // Pega o cluster do .env
//     wsHost: window.location.hostname,
//     wsPort: 6001,  // Porta do WebSocket do Laravel
//     forceTLS: false,
//     disableStats: true,
//     enabledTransports: ['ws', 'wss'],
// });


import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Definir o Pusher no escopo global
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    wsHost: import.meta.env.VITE_PUSHER_HOST || window.location.hostname,
    wsPort: 443,
    wssPort: 443,
    forceTLS: true,
    enabledTransports: ['wss'], // Apenas WebSocket seguro
    disableStats: true,
    authEndpoint: '/broadcasting/auth', // Confirme que este endpoint está ativo
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
        },
    },
});


// Exemplo de como se conectar a um canal privado
window.Echo.private('chat.' + userId)
    .listen('NewMessage', (event) => {
        console.log(event);
    });

// Configuração de debug para inspecionar o socket_id
window.Echo.connector.pusher.connection.bind('state_change', function(states) {
    console.log('Estado do Pusher:', states);
});
