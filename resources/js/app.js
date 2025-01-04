import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// resources/js/app.js

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'local', // O "local" pode ser mantido, mas é importante que seja o mesmo nome da chave em "config/websockets.php"
    cluster: 'mt1', // Ajuste para o cluster se necessário, mas pode ser 'mt1' para local
    wsHost: window.location.hostname, // Isso garante que o Echo tente se conectar ao host local
    wsPort: 6002, // Certifique-se de que está apontando para a porta correta (6001)
    disableStats: true, // Desabilita as estatísticas de Pusher
    forceTLS: true // Não usar TLS para ambientes de desenvolvimento local
});

window.Echo.channel('events')
    .listen('NewEventCreated', (event) => {
        console.log(event.message); // Exibe a mensagem no console
    });