import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

// Inicializa o Echo
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
            'X-Socket-ID': window.Echo.socketId(), // Garantir que o socket ID é enviado corretamente
        },
    },
});

// Confirmação de que a instância de Echo foi criada
console.log("Instância de Echo criada com sucesso!");

// Verifique o estado da conexão Pusher
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

// Após garantir que o Echo foi inicializado corretamente
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

// Verificando se a instância de Echo foi criada corretamente e se o método channel está disponível
if (window.Echo && typeof window.Echo.channel === 'function') {
    console.log("Método 'channel' está disponível.");
    // Subscribing to the channel after Echo is initialized
    window.Echo.channel('chat.' + userId)
        .listen('NewMessage', (event) => {
            console.log('Nova mensagem recebida:', event.message);
        })
        .error((error) => {
            console.error('Erro de Pusher:', error);
        });
} else {
    console.error("Método 'channel' não está disponível na instância de Echo.");
}
