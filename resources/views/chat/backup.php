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
                                Amigos
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
                                        <h4>Usuários Online</h4>
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
    <div class="col-xxl-6 col-xl-12">
        <div class="card h-100 overflow-hidden mb-0">
            <div class="card-header border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <a href="javascript: void(0);" class="btn btn-light px-1 d-xxl-none d-inline-flex" data-bs-toggle="offcanvas" data-bs-target="#emailSidebaroffcanvas" aria-controls="emailSidebaroffcanvas">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="menu" class="lucide lucide-menu font-18"><line x1="4" x2="20" y1="12" y2="12"></line><line x1="4" x2="20" y1="6" y2="6"></line><line x1="4" x2="20" y1="18" y2="18"></line></svg>
                    </a>

                    <div class="d-flex align-items-start me-auto">
                        <img src="assets/images/users/avatar-5.jpg" class="me-2 rounded" height="36" alt="Brandon Smith">
                        <div>
                            <h5 class="mt-0 mb-0 font-15">
                                <a href="pages-profile.html" class="text-reset">Shreyu N</a>
                            </h5>
                            <p class="mt-1 lh-1 mb-0 text-muted font-12">
                                <small class="mdi mdi-circle text-success"></small> Online
                            </p>
                        </div>
                    </div>

                    {{-- <div class="d-flex gap-3">
                        <div class="d-none d-lg-inline-flex gap-3">
                            <a href="javascript: void(0);" class="text-body font-18 d-inline-flex" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Voice Call" data-bs-original-title="Voice Call">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="phone-call" class="lucide lucide-phone-call"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path><path d="M14.05 2a9 9 0 0 1 8 7.94"></path><path d="M14.05 6A5 5 0 0 1 18 10"></path></svg>
                            </a>

                            <a href="javascript: void(0);" class="text-body font-18 d-inline-flex" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Video Call" data-bs-original-title="Video Call">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="video" class="lucide lucide-video"><path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"></path><rect x="2" y="6" width="14" height="12" rx="2"></rect></svg>
                            </a>

                            <a href="javascript: void(0);" class="text-body font-18 d-inline-flex" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Add Users" data-bs-original-title="Add Users">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="user-plus" class="lucide lucide-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" x2="19" y1="8" y2="14"></line><line x1="22" x2="16" y1="11" y2="11"></line></svg>
                            </a>

                            <a href="javascript: void(0);" class="text-body font-18 d-inline-flex" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Delete Chat" data-bs-original-title="Delete Chat">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="trash-2" class="lucide lucide-trash-2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line></svg>
                            </a>
                        </div>

                        <a href="javascript: void(0);" class="text-body font-18 d-xxl-none d-inline-flex" data-bs-toggle="offcanvas" data-bs-target="#userInfoOffcanvas" aria-controls="userInfoOffcanvas">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="info" class="lucide lucide-info"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                        </a>
                    </div> --}}
                </div>
            </div>

            <div class="card-body p-0 pt-3">
                <ul id="message-list">
                @foreach ($messages as $message)
                    @php
                        $isUserMessage = auth()->id() == $message->sender_id;
                    @endphp
                    <li class="message {{ $isUserMessage ? 'user-message' : 'admin-message' }}">
                        <div class="message-content">
                            <strong>{{ $message->user->name ?? 'Usuário desconhecido' }}:</strong>
                            {{ $message->content }}
                        </div>
                        <span class="message-time">{{ \Carbon\Carbon::parse($message['updated_at'])->format('H:i') }}</span>
                    </li>
                @endforeach
            </ul> 
            </div> <!-- end card-body -->

            <div class="card-body bg-light mt-2">
                <form wire:submit.prevent="sendMessage" class="" name="chat-form" id="chat-form">
                    <div class="row">
                        <div class="col mb-2 mb-sm-0">
                            <!-- O input agora usa wire:model para se conectar ao Livewire -->
                            <input type="text" wire:model="newMessage" class="form-control border-0"
                                   placeholder="Digite uma mensagem...">
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
        </div> <!-- end card -->
    </div>
    <!-- end chat area-->
</div>

<script>
    //const socket = io('https://proconline.com.br:6001');
    const socket = io('http://localhost:6002');
    const userId = @json(auth()->id()); // Corrigido para evitar erro com usuários não autenticados

    // Notifica o servidor que o usuário está online
    socket.emit('user connected', { id: userId, name: "{{ auth()->user()->name }}" });

    document.getElementById('chat-form').addEventListener('submit', function(event) {
        event.preventDefault();
        let messageInput = document.querySelector('[wire\\:model="newMessage"]');
        let message = messageInput.value;

        if (message.trim() !== '') {
            // Enviar a mensagem com a hora atual
            socket.emit('chat message', { content: message, sender_id: userId });
            messageInput.value = '';
        }
    });

    socket.on('chat message', function(msg) {
        let messageList = document.getElementById('message-list');
        let li = document.createElement('li');

        // Definir a classe para diferenciar mensagens do usuário e do admin
        let messageClass = (msg.user && msg.user.id === userId) ? 'user-message' : 'admin-message';
        li.classList.add('message', messageClass);

        // Formatar a hora da mensagem
        // Cria um objeto Date para pegar a data e hora atuais
        const now = new Date();

        // Obtém a hora e o minuto
        const hours = now.getHours();  // Hora (0-23)
        const minutes = now.getMinutes();  // Minutos (0-59)

        // Adiciona um zero à esquerda se a hora ou o minuto for menor que 10
        const formattedTime = `${hours < 10 ? '0' : ''}${hours}:${minutes < 10 ? '0' : ''}${minutes}`;

        // Definir o conteúdo da mensagem
        li.innerHTML = `
            <div class="message-content">
                <div class="message-header">
                    <strong>${msg.user ? msg.user.name : 'Usuário desconhecido'}</strong>
                </div>
                <p class="message-text">${msg.content}</p>
                <span class="message-time">${formattedTime}</span>
            </div>
        `;

        messageList.appendChild(li);
        messageList.scrollTop = messageList.scrollHeight; // Scroll automático para a última mensagem
    });

        // Atualizar a lista de usuários online, excluindo o próprio usuário
        socket.on('update online users', function(users) {
    let onlineUsersContainer = document.getElementById('online-users');
    onlineUsersContainer.innerHTML = '';

    users.forEach(user => { // Agora inclui usuários online e offline
        let userElement = document.createElement('div');
        userElement.classList.add('online-user');
        userElement.setAttribute('data-user-id', user.id); // Atributo para identificar o usuário

        let statusClass = user.status === 'offline' ? 'text-danger' : 'text-success';
        let statusText = user.status === 'offline' ? 'Offline' : 'Online';

        userElement.innerHTML = `
            <div class="d-flex align-items-start mt-1 p-2">
                <img src="assets/images/users/avatar-2.jpg" class="me-2 rounded-circle" height="48" alt="${user.name}">
                <div class="w-100 overflow-hidden">
                    <h5 class="mt-0 mb-0 font-14">${user.name}</h5>
                    <p class="mt-1 lh-1 mb-0 text-muted font-12">
                        <small class="mdi mdi-circle ${statusClass} user-status"></small> ${statusText}
                    </p>
                </div>
            </div>
        `;
        onlineUsersContainer.appendChild(userElement);
    });
});

// Quando um usuário desconectar, exibir como offline
socket.on('user disconnected', function(user) {
    let userElement = document.querySelector(`[data-user-id="${user.id}"]`);
    
    if (userElement) {
        let statusElement = userElement.querySelector('.user-status');
        statusElement.classList.remove('text-success'); // Remove o verde
        statusElement.classList.add('text-danger'); // Adiciona vermelho
        statusElement.textContent = ' Offline';
    }
});


</script>


@endsection