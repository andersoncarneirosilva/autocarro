// DESENVOLVIMENTO

// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';

// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
//     wsHost: import.meta.env.VITE_PUSHER_HOST,
//     wsPort: import.meta.env.VITE_PUSHER_PORT,
//     wssPort: null,  // Não usar o protocolo wss em ambientes não SSL
//     forceTLS: false,  // Garantir que o TLS (HTTPS) não seja utilizado, caso esteja usando http
//     enabledTransports: ['ws'],  // Usar somente WebSocket não seguro (para desenvolvimento local)
//     disableStats: true,
//     authEndpoint: '/broadcasting/auth',
//     auth: {
//         headers: {
//             'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
//         },
//     },
// });

// console.log("Instância de Echo criada com sucesso!");

// window.Echo.connector.pusher.connection.bind('state_change', function(states) {
//     console.log("Estado da conexão Pusher:", states);
//     if (states.current === 'connected') {
//         console.log("Conexão Pusher estabelecida com sucesso!");
//     }
// });


// PRODUCAO
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Pusher.logToConsole = true; // Ativa os logs de Pusher no console

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    wsHost: import.meta.env.VITE_PUSHER_HOST,
     wsPort: import.meta.env.VITE_PUSHER_PORT,
     wssPort: null,  // Não usar o protocolo wss em ambientes não SSL
    forceTLS: true,
    disableStats: true,
    authEndpoint: '/broadcasting/auth',
    auth: {
         headers: {
             'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
         },
     },
});

console.log("Pusher Echo configurado e pronto para ouvir eventos.");