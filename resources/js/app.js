// app.js
import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    console.log("Iniciando escuta no canal 'chat'...");

    // Escutando no WebSocket para Nova Mensagem
    window.Echo.channel('chat')
        .listen('NewMessage', (event) => {
            console.log('Nova mensagem recebida via WebSocket:', event);

            const messageList = document.getElementById('message-list');
            
            // Criar a estrutura HTML para a nova mensagem
            const newMessage = document.createElement('li');
            const senderClass = event.sender_id === 'auth-user-id' ? 'user-message' : 'admin-message'; // Ajuste para seu ID de usuário
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

            // Adicionar a nova mensagem ao chat
            messageList.appendChild(newMessage);

            // Rola até a última mensagem
            messageList.scrollTop = messageList.scrollHeight;
        });
});
