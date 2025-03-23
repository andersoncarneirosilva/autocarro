// DESENVOLVIMENTO
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    wsHost: import.meta.env.VITE_PUSHER_HOST,  // Defina o host do WebSocket
    wsPort: import.meta.env.VITE_PUSHER_PORT,  // Defina a porta do WebSocket (6001 para WebSockets personalizados)
    forceTLS: true,  // Forçar o uso de TLS (HTTPS/WSS)
    encrypted: true, // Garantir que a conexão seja criptografada
    disableStats: true, // Desativar as estatísticas do Pusher para melhorar a performance (se necessário)
});

console.log("Instância de Echo criada com sucesso!");

window.Echo.connector.pusher.connection.bind('state_change', function(states) {
    console.log("Estado da conexão Pusher:", states);
    if (states.current === 'connected') {
        console.log("Conexão Pusher estabelecida com sucesso!");
    }
});



// PRODUCAO
// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Pusher.logToConsole = true; // Ativa os logs de Pusher no console

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
//     forceTLS: true,
//     disableStats: true,
//     authEndpoint: '/broadcasting/auth',
//     auth: {
//          headers: {
//              'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
//          },
//      },
// });

// console.log("Pusher Echo configurado e pronto para ouvir eventos.");