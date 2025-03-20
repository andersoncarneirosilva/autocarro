import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    console.log("Iniciando escuta no canal 'chat'...");

    const messageList = document.getElementById('message-list');

    window.Echo.channel('chat')
    .listen('NewMessage', (event) => {
        console.log('Nova mensagem recebida:', event);
        // Seu código para processar a mensagem
    });

console.log('Escutando no canal chat...');

});
