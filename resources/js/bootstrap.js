import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    wsHost: import.meta.env.VITE_PUSHER_HOST,
    wsPort: import.meta.env.VITE_PUSHER_PORT,
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

console.log("Instância de Echo criada com sucesso!");

window.Echo.connector.pusher.connection.bind('state_change', function(states) {
    console.log("Estado da conexão Pusher:", states);
    if (states.current === 'connected') {
        console.log("Conexão Pusher estabelecida com sucesso!");
        const socketId = window.Echo.socketId();
        console.log("Socket ID conectado:", socketId);
        window.socketId = socketId; // Armazene o socket ID globalmente
    }
});

document.addEventListener("livewire:request", (event) => {
    const checkSocketIdInterval = setInterval(() => {
        const socketId = window.socketId;
        if (socketId && socketId !== "undefined") {
            event.detail.headers["X-Socket-ID"] = socketId;
            console.log("Enviando Socket ID:", socketId);
            clearInterval(checkSocketIdInterval); // Parar a verificação quando o socketId estiver disponível
        } else {
            console.warn("Socket ID ainda não está disponível!");
        }
    }, 100); // Verifica a cada 100ms até o socketId estar disponível
});

