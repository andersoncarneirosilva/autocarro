import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

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

// Aguarde o Pusher se conectar antes de capturar o Socket ID
window.Echo.connector.pusher.connection.bind('connected', function () {
    console.log("Socket ID conectado:", window.Echo.socketId());
});

// Adicionar o socket_id às requisições Livewire apenas após conexão
document.addEventListener("livewire:request", (event) => {
    setTimeout(() => {
        if (window.Echo.socketId()) {
            event.detail.headers["X-Socket-ID"] = window.Echo.socketId();
            console.log("Enviando Socket ID:", window.Echo.socketId());
        } else {
            console.warn("Socket ID ainda não está disponível!");
        }
    }, 500); // Aguarda conexão antes de enviar requisição
});
