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
    enabledTransports: ['wss'],
    disableStats: true,
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
        },
    },
});

// Adicionar o socket_id às requisições Livewire
document.addEventListener("livewire:request", (event) => {
    if (window.Echo.socketId()) {
        event.detail.headers["X-Socket-ID"] = window.Echo.socketId();
        console.log("Enviando Socket ID:", window.Echo.socketId()); // Debug
    } else {
        console.warn("Socket ID não encontrado!");
    }
});

// Debug para garantir que o socket ID está conectado
window.Echo.connector.pusher.connection.bind('connected', function () {
    console.log("Socket ID conectado:", window.Echo.socketId());
});
