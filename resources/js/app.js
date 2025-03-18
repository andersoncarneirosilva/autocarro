import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    console.log("Iniciando escuta no canal 'app.js'...");
    console.log("authUserId:", window.authUserId);
    console.log("chatId:", window.chatId); // <-- Precisamos garantir que o chatId esteja definido

    const messageList = document.getElementById('message-list');

    if (messageList && window.authUserId && window.chatId) {
        // Certifique-se de que o usuário não está inscrito em outro canal
        window.Echo.leave('private-chat.' + window.chatId);  // Deixa o canal antes de se inscrever novamente

        // Inscreve no canal compartilhado da conversa
        window.Echo.private('chat.' + window.chatId)
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
        console.warn("Elemento #message-list não encontrado ou authUserId/chatId não definidos.");
    }
});
