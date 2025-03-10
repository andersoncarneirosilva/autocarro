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

// Configurar o Pusher no Laravel Echo
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,  // Pega a chave do .env
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER, // Pega o cluster do .env
    wsHost: window.location.hostname,  // Usa o hostname atual, útil para produção
    wsPort: 443,  // Pusher usa o porto 443 para HTTPS
    forceTLS: true,  // Garante que a conexão será via HTTPS
    disableStats: true,  // Desabilita estatísticas para melhorar performance
    enabledTransports: ['wss'],  // Prioriza WebSocket seguro
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
        },
    },
});
