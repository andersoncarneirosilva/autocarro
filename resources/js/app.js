import './bootstrap';
document.addEventListener('DOMContentLoaded', function () {
    console.log("Iniciando escuta no canal 'app.js'...");
    console.log("authUserId:", window.authUserId);
    const messageList = document.getElementById('message-list');

    if (messageList) {
        window.Echo.channel('chat.' + window.authUserId)  // Usando o authUserId definido
        .listen('NewMessage', (event) => {
            console.log('Nova mensagem recebida:', event);
        });
    } else {
        console.warn("Elemento #message-list não encontrado.");
    }
});
