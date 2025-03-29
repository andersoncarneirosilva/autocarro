// DESENVOLVIMENTO
// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';

// window.Pusher = Pusher;
// window.Pusher.logToConsole = true;
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: window.location.hostname,
//     wsPort: 6001,
//     wssPort: 6001,
//     forceTLS: false,
//     encrypted: false,
//     authEndpoint: '/broadcasting/auth',
//     auth: {
//     headers: {
//         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
//     },
// },

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
window.Pusher.logToConsole = true;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,  // Variável de ambiente para a chave do Pusher
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    wsHost: 'proconline.com.br',  // Servidor do WebSocket
    wsPort: 443,  // Porta 443 para HTTPS
    wssPort: 443, // Porta 443 para WebSocket seguro (wss)
    forceTLS: true,  // Forçar uso de TLS
    encrypted: true,  // Encriptação habilitada
    authEndpoint: '/broadcasting/auth',  // Endpoint de autenticação
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
    },
});




// PRODUCAO
// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';

// window.Pusher = Pusher;
// window.Pusher.logToConsole = true;  // Ativar para depuração, pode ser removido em produção
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     encrypted: true,
//     forceTLS: true,
//     authEndpoint: '/broadcasting/auth',
//     auth: {
//     headers: {
//         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
//     },
// },

// });

// console.log("Instância de Echo criada com sucesso!");

// window.Echo.connector.pusher.connection.bind('state_change', function(states) {
//     console.log("Estado da conexão Pusher:", states);
//     if (states.current === 'connected') {
//         console.log("Conexão Pusher estabelecida com sucesso!");
//     }
// });


