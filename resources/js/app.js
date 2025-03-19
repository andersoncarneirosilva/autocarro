import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    console.log("Iniciando escuta no canal 'chat'...");

    const messageList = document.getElementById('message-list');

    if (messageList) {
        window.Echo.channel('chat')
    .listen('.NewMessage', (event) => {
        console.log('Nova mensagem recebida:', event); // Verifique o evento completo

        if (event && event.content && event.sender_id && event.created_at) {
            const newMessage = document.createElement('li');
            const senderClass = event.sender_id === window.authUserId ? 'user-message' : 'admin-message';
            newMessage.classList.add(senderClass);

            // Formatar a hora com 'H:i'
            const createdAt = new Date(event.created_at);
            const formattedTime = createdAt.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            newMessage.innerHTML = `
                <div class="conversation-text">
                    <div class="ctext-wrap">
                        <p>${event.content}</p>
                    </div>
                    <span class="message-time">${formattedTime}</span>
                </div>
            `;

            messageList.appendChild(newMessage);
            messageList.scrollTop = messageList.scrollHeight;
        } else {
            console.error('Mensagem inválida recebida:', event);
        }
    });
    } else {
        console.warn("Elemento #message-list não encontrado.");
    }
});
