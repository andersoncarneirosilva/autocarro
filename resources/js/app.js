import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    console.log("Iniciando escuta no canal 'chat'...");

    const messageList = document.getElementById('message-list');

    if (messageList) {
        var channel = pusher.subscribe('chat');

        channel.bind('my-event', function(data) {
        
          alert('Received my-event with message: ' + data.message);
        
        });
    } else {
        console.warn("Elemento #message-list não encontrado.");
    }
});
