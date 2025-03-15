import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

console.log("Inicializando Pusher e Echo...");

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

// Verifique a conexão Pusher
window.Echo.connector.pusher.connection.bind('state_change', function(states) {
    console.log("Estado da conexão Pusher:", states);
    if (states.current === 'connected') {
        console.log("Conexão Pusher estabelecida com sucesso!");
    }
});

// Aguarde o Pusher se conectar antes de capturar o Socket ID
window.Echo.connector.pusher.connection.bind('connected', function () {
    console.log("Socket ID conectado:", window.Echo.socketId());
    // Atualiza a variável para garantir que o socketId seja enviado
    window.socketId = window.Echo.socketId();
});

// Adicionar o socket_id às requisições Livewire apenas após a conexão
document.addEventListener("livewire:request", (event) => {
    setTimeout(() => {
        if (window.socketId) {
            event.detail.headers["X-Socket-ID"] = window.socketId;
            console.log("Enviando Socket ID:", window.socketId);
        } else {
            console.warn("Socket ID ainda não está disponível!");
        }
    }, 500); // Aguarda conexão antes de enviar requisição
});
