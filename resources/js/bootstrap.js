import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Testando a conexão manual com Pusher
const pusher = new Pusher(import.meta.env.VITE_PUSHER_APP_KEY, {
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});

pusher.connection.bind('connected', function() {
    const socketId = pusher.connection.socket_id;
    console.log("Socket ID conectado manualmente:", socketId);  // Verifica o socketId manualmente
});

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    wsHost: import.meta.env.VITE_PUSHER_HOST,
    wsPort: import.meta.env.VITE_PUSHER_PORT,
    wssPort: 443,
    forceTLS: true,
    enabledTransports: ['ws', 'wss'],
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
    console.log("Estado da conexão Pusher:", states); // Verifique os estados

    if (states.current === 'connected') {
        console.log("Conexão Pusher estabelecida com sucesso!");
        const socketId = window.Echo.socketId();
        console.log("Socket ID conectado:", socketId); // Aqui você obterá o socket ID

        if (socketId) {
            window.socketId = socketId;
            console.log("Socket ID armazenado:", window.socketId); // Confirmação de armazenamento
        } else {
            console.warn("Socket ID não foi recebido.");
        }
    } else if (states.current === 'disconnected') {
        console.error("Conexão Pusher falhou!");
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
    }, 200); // Verifica a cada 200ms até o socketId estar disponível
});
