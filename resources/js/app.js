import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    console.log("Iniciando escuta no canal 'app.js'...");
    console.log("authUserId:", window.authUserId);

    const messageList = document.getElementById('message-list');

    // Verifica se o canal já foi inscrito para evitar duplicações
    if (messageList && !window.chatChannel) {
        // Inscreve no canal correspondente ao usuário
        window.chatChannel = window.Echo.channel('chat.' + window.authUserId);

        // Escuta o evento 'NewMessage' do canal
        window.chatChannel.listen('NewMessage', (event) => {
            try {
                console.log('Nova mensagem recebida:', event); // Verifique os dados recebidos no console

                // Validação de dados da mensagem
                if (!event.id || !event.content || !event.sender_id || !event.created_at) {
                    console.error('Dados de mensagem inválidos:', event);
                    return;
                }

                // Criação da nova mensagem
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

                // Adiciona a nova mensagem à lista
                messageList.appendChild(newMessage);
                messageList.scrollTop = messageList.scrollHeight;

            } catch (error) {
                console.error('Erro ao processar a mensagem:', error);
            }
        });
    } else {
        console.warn("Elemento #message-list não encontrado ou canal já inscrito.");
    }
});
