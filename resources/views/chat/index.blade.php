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
        <div class="offcanvas-xxl offcanvas-start h-100 file-offcanvas" tabindex="-1" id="emailSidebaroffcanvas" aria-labelledby="emailSidebaroffcanvasLabel">
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
                        <div class="tab-pane show active card-body pb-0" id="newpost">

                            <!-- start search box -->
                            {{-- <div class="app-search">
                                <form>
                                    <div class="mb-2 w-100 position-relative">
                                        <input type="search" class="form-control" placeholder="People, groups &amp; messages...">
                                        <span class="mdi mdi-magnify search-icon"></span>
                                    </div>
                                </form>
                            </div> --}}
                            <!-- end search box -->
                        </div>

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
                                    {{-- <a href="javascript:void(0);" class="text-body">
                                        <div class="d-flex align-items-start mt-1 p-2">
                                            <img src="assets/images/users/avatar-2.jpg" class="me-2 rounded-circle" height="48" alt="Brandon Smith">
                                            <div class="w-100 overflow-hidden">
                                                <h5 class="mt-0 mb-0 font-14">
                                                    <span class="float-end text-muted font-12">4:30am</span>
                                                    Brandon Smith
                                                </h5>
                                                <p class="mt-1 mb-0 text-muted font-14">
                                                    <span class="w-25 float-end text-end"><span class="badge badge-danger-lighten">3</span></span>
                                                    <span class="w-75">How are you today?</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a> --}}

                                    
                                </div></div></div></div><div class="simplebar-placeholder" style="width: 272px; height: 834px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 443px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div> <!-- end simplebar-->
                            </div> <!-- End col -->
                        </div> <!-- end users -->
                    </div> <!-- end tab content-->
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
    </div>
    <!-- end chat users-->

    <!-- chat area -->
    <div class="col-xxl-6 col-xl-12" id="chat-area" style="display: none;">
        <div class="card h-100 overflow-hidden mb-0">
            <div class="card-header border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <a href="javascript:void(0);" class="btn btn-light px-1 d-xxl-none d-inline-flex" data-bs-toggle="offcanvas" data-bs-target="#emailSidebaroffcanvas" aria-controls="emailSidebaroffcanvas">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu font-18">
                            <line x1="4" x2="20" y1="12" y2="12"></line>
                            <line x1="4" x2="20" y1="6" y2="6"></line>
                            <line x1="4" x2="20" y1="18" y2="18"></line>
                        </svg>
                    </a>
    
                    <div class="d-flex align-items-start me-auto">
                        <img id="chat-user-avatar" src="assets/images/users/avatar-1.jpg" class="me-2 rounded" height="36" alt="">
                        <div>
                            <h5 class="mt-0 mb-0 font-15">
                                <a href="javascript:void(0);" class="text-reset" id="chat-user-name"></a>
                            </h5>
                            <p class="mt-1 lh-1 mb-0 text-muted font-12">
                                <small class="mdi mdi-circle text-success"></small> Online
                            </p>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="card-body p-0 pt-3">
                <ul id="message-list"></ul>
            </div>
    
            <div class="card-body bg-light mt-2">
                <form id="chat-form">
                    <div class="row">
                        <div class="col mb-2 mb-sm-0">
                            <input type="text" id="message-input" class="form-control border-0" placeholder="Digite uma mensagem...">
                        </div>
                        <div class="col-sm-auto">
                            <div class="btn-group">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success chat-send">
                                        <i class="uil uil-message"></i> Enviar
                                    </button>
                                </div>
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
    //const socket = io('http://localhost:6002');
    const socket = io('https://proconline.com.br:6001');
    const userId = JSON.parse("@json(auth()->id())");
    let chatId = null;

    console.log("Usuário logado:", userId);

    socket.emit('user connected', {
        id: userId,
        name: "{{ auth()->user()->name }}",
        token: "{{ auth()->user()->api_token }}"
    });


    socket.on('update online users', function(users) {
        console.log("Usuários online recebidos:", users);
        
        let onlineUsersContainer = document.getElementById('online-users');
        if (!onlineUsersContainer) return;
        onlineUsersContainer.innerHTML = '';

        users.forEach(user => {
    let userElement = document.createElement('div');
    userElement.classList.add('online-user');
    userElement.setAttribute('data-user-id', user.id);
    userElement.setAttribute('data-user-name', user.name);
    userElement.setAttribute('data-user-avatar', user.avatar || 'assets/images/users/avatar-1.jpg');

    let statusClass = user.status === 'offline' ? 'text-danger' : 'text-success';
    let statusText = user.status === 'offline' ? 'Offline' : 'Online';

    // Elemento do card do usuário com placeholder
    userElement.innerHTML = `
        <div class="d-flex align-items-start mt-1 p-2">
            <img src="${user.avatar || 'assets/images/users/avatar-1.jpg'}" class="me-2 rounded-circle" height="48" alt="${user.name}">
            <div class="w-100 overflow-hidden">
                <h5 class="mt-0 mb-0 font-14">${user.name}</h5>
                <p class="last-message mt-1 lh-1 mb-0 text-muted font-12 text-truncate" style="max-width: 200px;">
                    Carregando...
                </p>
            </div>
        </div>`;

    // Adiciona no container principal
    onlineUsersContainer.appendChild(userElement);

    // Buscar a última mensagem via endpoint
    fetch(`/chat/last-message?user_id=${userId}&recipient_id=${user.id}`)
        .then(response => response.json())
        .then(data => {
            const paragraph = userElement.querySelector('.last-message');
            if (paragraph) {
                paragraph.textContent = user.content ?? 'Sem mensagens ainda';

            }
        })
        .catch(err => {
            console.error(`Erro ao buscar última mensagem de ${user.name}:`, err);
        });


    // Evento de clique para abrir o chat
    userElement.addEventListener('click', function () {
        let selectedUserId = userElement.getAttribute('data-user-id');
        let selectedUserName = userElement.getAttribute('data-user-name');
        let selectedUserAvatar = userElement.getAttribute('data-user-avatar');

        console.log(`Selecionado usuário: ID ${selectedUserId}, Nome ${selectedUserName}`);
        chatUserName.innerText = selectedUserName;
        chatUserAvatar.setAttribute('src', selectedUserAvatar);
        chatArea.style.display = 'block';

        console.log("Solicitando criação/verificação de chat...");
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
                let li = document.createElement('li');
                let messageClass = msg.sender_id === userId ? 'user-message' : 'admin-message';
                li.classList.add('message', messageClass);
                li.innerHTML = `
                    <div class="message-content">
                        <div class="message-header">
                            <strong>${msg.sender_name}</strong>
                        </div>
                        <p class="message-text">${msg.content}</p>
                        <span class="message-time">${msg.timestamp}</span>
                    </div>`;
                messageList.appendChild(li);
            });
            messageList.scrollTop = messageList.scrollHeight;
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

    let li = document.createElement('li');
    let messageClass = data.sender_id === userId ? 'user-message' : 'admin-message';

    li.classList.add('message', messageClass);
    li.innerHTML = `
        <div class="message-content">
            <div class="message-header">
                <strong>${data.user?.name ?? data.sender?.name ?? 'Usuário desconhecido'}</strong>
            </div>
            <p class="message-text">${data.content}</p>
            <span class="message-time">${new Date(data.sent_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
        </div>`;

    messageList.appendChild(li);
    messageList.scrollTop = messageList.scrollHeight;
});





});

</script>




@endsection