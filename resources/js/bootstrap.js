// DESENVOLVIMENTO

// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';

// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
//     wssPort: 443,  // Não usar o protocolo wss em ambientes não SSL
//     forceTLS: true,  // Garantir que o TLS (HTTPS) não seja utilizado, caso esteja usando http

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
    key: process.env.VITE_PUSHER_APP_KEY,
    cluster: process.env.VITE_PUSHER_APP_CLUSTER,
    wsHost: 'example.com', // Your domain
    encrypted: true,
    wssPort: 443, // Https port
    disableStats: true, // Change this to your liking this disables statistics
    forceTLS: true,
    enabledTransports: ['ws', 'wss'],
    disabledTransports: ['sockjs', 'xhr_polling', 'xhr_streaming'] // Can be removed
})

console.log("Pusher Echo configurado e pronto para ouvir eventos.");