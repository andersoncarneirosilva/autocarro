@extends('layouts.app')

@section('title', 'Proconline')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
            <h3 class="page-title">Chat suporte</h3>
        </div>
    </div>
</div>
<br>
<div class="row">
    <!-- start chat users-->
    <div class="col-xxl-3">
        <div class="offcanvas-start h-100 file-offcanvas" tabindex="-1" id="emailSidebaroffcanvas" aria-labelledby="emailSidebaroffcanvasLabel">
            <div class="card h-100 mb-0">
                <div class="card-body p-0">
                    <ul class="nav nav-tabs nav-bordered nav-justified" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#allUsers" data-bs-toggle="tab" aria-expanded="false" class="nav-link active py-2" aria-selected="true" role="tab">
                                Colaboradores
                            </a>
                        </li>
                    </ul> <!-- end nav-->
                    <div class="tab-content">

                        <!-- users -->
                        <div class="row">
                            <div class="col">
                                <div class="card-body chat-user-list pt-0 simplebar-scrollable-y" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px -24px -24px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px 24px 24px;">
                                    <div class="online-users">
                                        {{-- <h4>Usuários Online</h4> --}}
                                        <div id="online-users">
                                            <!-- Aqui os usuários online serão listados dinamicamente -->
                                        </div>
                                    </div>                                    
                                </div></div></div></div><div class="simplebar-placeholder" style="width: 272px; height: 834px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 443px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div> <!-- end simplebar-->
                            </div> <!-- End col -->
                        </div> <!-- end users -->
                    </div> <!-- end tab content-->
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
    </div>
    <!-- end chat users-->    
    
    
</div>
<div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content" style="max-height: 90vh;">
        <div class="modal-header">
          <h5 class="modal-title" id="chatModalLabel">Chat</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        
        <div class="modal-body p-0" style="overflow: hidden;">
          <div id="chat-scroll-area" data-simplebar style="max-height: 60vh; padding: 1rem;">
            <ul id="message-list" class="conversation-list chat-conversation list-unstyled mb-0">
              <!-- mensagens vão aqui -->
            </ul>
          </div>
        </div>
  
        <div class="modal-footer" style="display: block;">
          <form id="chat-form">
            <div class="row gx-2">
              <div class="col mb-2 mb-sm-0">
                <input type="text" id="message-input" class="form-control border-0" placeholder="Digite uma mensagem...">
              </div>
              <div class="col-sm-auto">
                <div class="d-grid">
                  <button type="submit" class="btn btn-success chat-send">
                    <i class="uil uil-message"></i> Enviar
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
  
      </div>
    </div>
  </div>
  
  
<script>
document.addEventListener("DOMContentLoaded", function () {
    const chatArea = document.getElementById('chat-area');
    const chatUserName = document.getElementById('chat-user-name');
    const chatUserAvatar = document.getElementById('chat-user-avatar');
    const messageList = document.getElementById('message-list');
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');

    const socket = io('https://proconline.com.br', {
        path: '/socket.io',
        transports: ['websocket', 'polling']
    });
    // const socket = io('http://localhost:6002', {
    //     path: '/socket.io',
    //     transports: ['websocket', 'polling']
    // });

    const userId = JSON.parse("@json(auth()->id())");
    let chatId = null;

    console.log("Usuário logado:", userId);

    socket.emit('user connected', {
        id: userId,
        name: "{{ auth()->user()->name }}",
        image: "storage/{{ auth()->user()->image }}", 
        token: "{{ auth()->user()->api_token }}"
    });

    socket.on('update online users', function(users) {
    const onlineUsersContainer = document.getElementById('online-users');
    //onlineUsersContainer.innerHTML = ''; // Limpa a lista
    if (!onlineUsersContainer) return;

    users.forEach(user => {
        //console.log(user.image);
        const existing = onlineUsersContainer.querySelector(`.online-user[data-user-id="${user.id}"]`);
        
        if (existing) {
            // Atualiza contador de mensagens não lidas
            const badge = existing.querySelector('.badge');
            const newCount = parseInt(user.unread_count) || 0;

            if (badge) {
                badge.innerText = newCount > 0 ? newCount : '';
                badge.style.display = newCount > 0 ? 'inline-block' : 'none';
            }

            // Atualiza status se mudou
            // Atualiza status se mudou
            const statusEl = existing.querySelector('span.float-end.text-muted.font-12');
            if (statusEl) {
                let statusText = user.status || '';
                let statusIcon = '';

                if (user.status === 'Online') {
                    statusIcon = '<i class="mdi mdi-circle text-success me-1"></i>';
                } else if (user.status === 'Offline') {
                    statusIcon = '<i class="mdi mdi-circle text-danger me-1"></i>';
                }

                statusEl.innerHTML = `${statusIcon}${statusText}`;
            }


            // Atualiza texto da última mensagem
            const messageTextEl = existing.querySelector('.message-text');
            const newMessage = user.lastMessageContent ?? user.content ?? 'Sem mensagens ainda';
            if (messageTextEl && messageTextEl.innerText !== newMessage) {
                messageTextEl.innerText = newMessage;
            }

            return;
        }

        // Criação do novo usuário
        const userElement = document.createElement('div');
        userElement.classList.add('online-user');
        userElement.setAttribute('data-user-id', user.id);
        userElement.setAttribute('data-user-name', user.name);
        userElement.setAttribute('data-user-avatar', user.image || 'assets/images/users/avatar-1.jpg');

        const lastTime = user.timestamp
            ? new Date(user.timestamp).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
            : '';

        const lastMessage = user.lastMessageContent ?? user.content ?? 'Sem mensagens ainda';

        userElement.innerHTML = `
        <div class="user-item" data-user-id="${user.id}" data-user-name="${user.name}" data-bs-toggle="modal" data-bs-target="#chatModal" style="cursor: pointer;">
            <div class="d-flex align-items-start mt-1 p-2">
                <img src="${user.image || 'assets/images/users/avatar-1.jpg'}" class="me-2 rounded-circle" height="48" alt="${user.name}">
                <div class="w-100 overflow-hidden">
                    <h5 class="mt-0 mb-0 font-14">
                        <span class="float-end text-muted font-12">
    ${user.status === 'Online' ? 
        `<i class="mdi mdi-circle text-success me-1"></i>` : 
        user.status === 'Offline' ?
        `<i class="mdi mdi-circle text-danger me-1"></i>` :
        ''}
    ${user.status || ''}
</span>


                        ${user.name}
                    </h5>
                    <p class="last-message mt-1 lh-1 mb-0 text-muted font-12 text-truncate" style="max-width: 200px;">
                        <span class="w-25 float-end text-end">
                            <span class="badge badge-danger-lighten" style="display: ${user.unread_count > 0 ? 'inline-block' : 'none'}">
                                ${user.unread_count || ''}
                            </span>
                        </span>
                        <span class="message-text">${lastMessage}</span>
                    </p>
                </div>
            </div>
        </div>`;

        onlineUsersContainer.appendChild(userElement);

        // Buscar a última mensagem via endpoint
        fetch(`/chat/last-message?user_id=${userId}&recipient_id=${user.id}`)
            .then(response => response.json())
            .then(data => {
    const messageText = userElement.querySelector('.message-text');
    const badge = userElement.querySelector('.badge');

    if (messageText && data && data.message) {
        messageText.textContent = data.message;
    }

    if (badge) {
        badge.innerText = data.unread_count || '';
        badge.style.display = data.unread_count > 0 ? 'inline-block' : 'none';
    }
})

            .catch(err => {
                console.error(`Erro ao buscar última mensagem de ${user.name}:`, err);
            });

        // Referência ao modal Bootstrap
const chatModalElement = document.getElementById('chatModal');
const chatModal = new bootstrap.Modal(chatModalElement);
const chatModalTitle = document.getElementById('chatModalLabel');
const chatModalAvatar = document.getElementById('chatModalAvatar'); // Se tiver um <img> no header da modal

// Evento de clique para abrir o chat na modal
userElement.addEventListener('click', function () {
    let selectedUserId = userElement.getAttribute('data-user-id');
    let selectedUserName = userElement.getAttribute('data-user-name');
    let selectedUserAvatar = userElement.getAttribute('data-user-avatar');

    console.log(`Selecionado usuário: ID ${selectedUserId}, Nome ${selectedUserName}`);

    // Atualiza header da modal
    chatModalTitle.innerText = `Chat com ${selectedUserName}`;
    if (chatModalAvatar) {
        chatModalAvatar.setAttribute('src', selectedUserAvatar);
    }

    // Abre a modal
    chatModal.show();

    // Requisição para criar/obter chat e mensagens
    fetch(`/chat/get-chat`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ recipient_id: selectedUserId }),
    })
    .then(response => response.json())
    .then(chat => {
        if (!chat.id) throw new Error("Chat ID não encontrado");
        chatId = chat.id;
        console.log(`Chat encontrado/criado: ID ${chatId}`);
        return fetch(`/chat/messages/${chatId}`);
    })
    .then(response => response.json())
    .then(messages => {
        console.log("Mensagens carregadas:", messages);
        messageList.innerHTML = '';
        messages.forEach(msg => {
            console.log(msg);
            let li = document.createElement('li');
            let isMine = msg.sender_id === userId;
            let liClass = `clearfix ${isMine ? 'odd' : ''}`;
            let dropdownClass = isMine ? '' : 'dropdown-menu-end';

            li.className = liClass;
            li.innerHTML = `
                <div class="chat-avatar">
                    <img src="storage/${msg.image || 'assets/images/users/avatar-6.jpg'}" class="rounded" alt="${msg.sender_name}">
                    <i>${msg.timestamp}</i>
                </div>
                <div class="conversation-text">
                    <div class="ctext-wrap">
                        <i>${msg.sender_name}</i>
                        <p>${msg.content}</p>
                    </div>
                </div
            `;
            messageList.appendChild(li);
        });

        messageList.scrollTop = messageList.scrollHeight;

        // Marcar como lidas
        fetch(`/chat/mark-as-read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ chat_id: chatId }),
        })
        .then(() => {
            const badge = userElement.querySelector('.badge');
            if (badge) {
                badge.innerText = '';
                badge.style.display = 'none';
            }
        })
        .catch(err => console.error('Erro ao marcar mensagens como lidas:', err));
    })
    .catch(error => console.error('Erro ao carregar mensagens:', error));
});

    });
});


    chatForm.addEventListener('submit', function(event) {
    event.preventDefault();
    if (!chatId) {
        console.error("Erro: Nenhum chat selecionado.");
        return;
    }

    let message = messageInput.value.trim();
    if (message === '') return;

    socket.emit('chat message', {
        chat_id: chatId,
        content: message,
        sender_id: userId,
        token: '{{ auth()->user()->api_token }}' // ou outro token JWT, se estiver usando
    });

    messageInput.value = ''; // limpa o input
});


socket.on('chat message', (data) => {
    console.log("Mensagem recebida via socket:", data);

    if (data.chat_id !== chatId) return;

    const isMine = data.sender_id === userId;
    const senderName = data.user?.name ?? data.sender?.name ?? 'Usuário desconhecido';
    const avatarUrl = data.user?.image || data.sender?.image || 'assets/images/users/avatar-5.jpg';
    const timestamp = new Date(data.sent_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    const dropdownClass = isMine ? '' : 'dropdown-menu-end';

    const li = document.createElement('li');
    li.className = `clearfix ${isMine ? 'odd' : ''}`;

    li.innerHTML = `
        <div class="chat-avatar">
            <img src="storage/${avatarUrl}" class="rounded" alt="${senderName}">
            <i>${timestamp}</i>
        </div>
        <div class="conversation-text">
            <div class="ctext-wrap">
                <i>${senderName}</i>
                <p>${data.content}</p>
            </div>
        </div>
        <div class="conversation-actions dropdown">
            <button class="btn btn-sm btn-link" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="uil uil-ellipsis-v"></i>
            </button>
            <div class="dropdown-menu ${dropdownClass}">
                <a class="dropdown-item" href="#">Copy Message</a>
                <a class="dropdown-item" href="#">Edit</a>
                <a class="dropdown-item" href="#">Delete</a>
            </div>
        </div>
    `;

    messageList.appendChild(li);
    messageList.scrollTop = messageList.scrollHeight;
});






});

</script>




@endsection