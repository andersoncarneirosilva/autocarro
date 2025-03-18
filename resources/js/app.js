import './bootstrap';
import './test';

document.addEventListener('DOMContentLoaded', function () {
    console.log("Iniciando escuta no canal 'chat.{userId}'...");

    const messageList = document.getElementById('message-list');
    const userId = window.authUserId;  // Certifique-se de que `authUserId` está disponível

    if (messageList) {
        // Assinando o canal privado 'chat.{userId}'
        window.Echo.private('chat.' + userId)
            .listen('NewMessage', (event) => {
                try {
                    console.log('Nova mensagem recebida:', event);

                    if (!event.content) {
                        console.error('Dados de mensagem inválidos:', event);
                        return;
                    }

                    const newMessage = document.createElement('li');
                    const senderClass = event.sender_id === userId ? 'user-message' : 'admin-message';
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

                } catch (error) {
                    console.error('Erro ao processar a mensagem:', error);
                }
            });
    } else {
        console.warn("Elemento #message-list não encontrado.");
    }
});
