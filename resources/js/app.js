import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    console.log("Iniciando escuta no canal 'app.js'...");

    const messageList = document.getElementById('message-list');

    if (messageList) {
        window.Echo.channel('chat')
            .listen('NewMessage', (event) => {
                console.log('Nova mensagem recebida via WebSocket:', event);

                const newMessage = document.createElement('li');
                const senderClass = event.sender_id === window.authUserId ? 'user-message' : 'admin-message';
                newMessage.classList.add(senderClass);

                newMessage.innerHTML = `
                    <div class="chat-avatar">
                        <i>${event.created_at}</i>
                    </div>
                    <div class="conversation-text">
                        <div class="ctext-wrap">
                            <p>${event.message}</p>
                        </div>
                    </div>
                `;

                messageList.appendChild(newMessage);
                messageList.scrollTop = messageList.scrollHeight;
            });
    } else {
        console.warn("Elemento #message-list não encontrado.");
    }
});