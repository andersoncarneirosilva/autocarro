// import './bootstrap';

// document.addEventListener('DOMContentLoaded', function () {
//     console.log("Iniciando escuta no canal 'chat'...");

//     const messageList = document.getElementById('message-list');

//     if (messageList) {
//         window.Echo.channel('chat')
//             .listen('.NewMessage', (event) => {  // Adicione o ponto antes do nome do evento
//                 console.log('Nova mensagem recebida:', event);
//                 if (event && event.content && event.sender_id && event.created_at) {
//                     const newMessage = document.createElement('li');
//                     const senderClass = event.sender_id === window.authUserId ? 'user-message' : 'admin-message';
//                     newMessage.classList.add(senderClass);

//                     // Formatar a hora com 'H:i'
//                     const createdAt = new Date(event.created_at);
//                     const formattedTime = createdAt.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

//                     newMessage.innerHTML = `
//                         <div class="conversation-text">
//                             <div class="ctext-wrap">
//                                 <p>${event.content}</p>
//                             </div>
//                             <span class="message-time">${formattedTime}</span>
//                         </div>
//                     `;

//                     messageList.appendChild(newMessage);
//                     messageList.scrollTop = messageList.scrollHeight;
//                 } else {
//                     console.error('Mensagem inválida recebida:', event);
//                 }
//             })
//             .error((error) => {
//                 console.error('Erro ao escutar o evento:', error);
//             });
//     } else {
//         console.warn("Elemento #message-list não encontrado.");
//     }
// });


import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    const chatId = 1; // Exemplo, o ID do chat. Isso pode ser dinâmico, dependendo de como você gerencia os chats.
    const messageList = document.getElementById('message-list');

    if (messageList) {
        window.Echo.private('chat.' + chatId) // Remova o "private-"

            .listen('.NewMessage', (event) => {
                console.log('Nova mensagem recebida:', event);
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
            })
            .error((error) => {
                console.error('Erro ao escutar o evento:', error);
            });
    } else {
        console.warn("Elemento #message-list não encontrado.");
    }
});
