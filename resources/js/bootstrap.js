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

// Definir Pusher no escopo global
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
    authEndpoint: '/broadcasting/auth', // Endpoint de autenticação
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
        },
    },
});

// Aguardar o carregamento da página antes de acessar userId
document.addEventListener('DOMContentLoaded', function () {
    if (typeof userId !== 'undefined' && userId !== null) {
        console.log(`Iniciando escuta no canal privado chat.${userId}...`);
        
        window.Echo.private(`chat.${userId}`)
            .listen('NewMessage', (event) => {
                console.log("Nova mensagem recebida:", event);
            });
    } else {
        console.warn("Usuário não autenticado ou userId não definido.");
    }
});

// Debug: Exibir o socket ID após conexão
window.Echo.connector.pusher.connection.bind('connected', function() {
    console.log("Socket ID conectado:", window.Echo.socketId());
});
