import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    console.log("Iniciando escuta no canal 'chat'...");

    const messageList = document.getElementById('message-list');

    if (messageList) {
        window.Echo.channel('chat')
            .listen('NewMessage', (event) => {
                console.log('Nova mensagem recebida:', event);

                // Adapte o formato para se ajustar à estrutura que você recebe
                const newMessage = document.createElement('li');
                const senderClass = event.data.sender_id === window.authUserId ? 'user-message' : 'admin-message';
                newMessage.classList.add(senderClass);

                // Formatando a hora (caso 'created_at' não seja enviado, utilize o horário atual)
                const createdAt = new Date(event.data.created_at || new Date());
                const formattedTime = createdAt.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                newMessage.innerHTML = `
                    <div class="conversation-text">
                        <div class="ctext-wrap">
                            <p>${event.data.content}</p>
                        </div>
                        <span class="message-time">${formattedTime}</span>
                    </div>
                `;

                messageList.appendChild(newMessage);
                messageList.scrollTop = messageList.scrollHeight;
            });
    } else {
        console.warn("Elemento #message-list não encontrado.");
    }
});
