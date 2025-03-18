import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    console.log("Iniciando escuta no canal 'app.js'...");
    console.log("authUserId:", window.authUserId);

    const messageList = document.getElementById('message-list');

    if (messageList && window.authUserId) {
        if (window.Echo) {
            const privateChannel = 'private-chat.' + window.authUserId;

            // Sai do canal público "chat" se ainda estiver inscrito
            if (window.Echo.channel('chat')) {
                console.log("Saindo do canal público 'chat'...");
                window.Echo.leave('chat');
            }

            // Sai do canal privado antes de se inscrever novamente
            if (window.Echo.channel(privateChannel)) {
                console.log(`Saindo do canal ${privateChannel} antes de se inscrever novamente...`);
                window.Echo.leave(privateChannel);
            }
        } else {
            console.warn("window.Echo não está definido!");
        }

        // Inscreve-se apenas no canal privado correto
        window.Echo.private('private-chat.' + window.authUserId)
            .listen('NewMessage', (event) => {
                try {
                    console.log('Nova mensagem recebida:', event);

                    if (!event.id || !event.content || !event.sender_id || !event.created_at) {
                        console.error('Dados de mensagem inválidos:', event);
                        return;
                    }

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

                } catch (error) {
                    console.error('Erro ao processar a mensagem:', error);
                }
            });

    } else {
        console.warn("Elemento #message-list não encontrado ou authUserId não definido.");
    }
});
