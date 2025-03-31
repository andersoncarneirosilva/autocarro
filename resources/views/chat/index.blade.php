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
    <div class="col-xxl-3">
        <div class="offcanvas-xxl offcanvas-start h-100 file-offcanvas" tabindex="-1" id="emailSidebaroffcanvas" aria-labelledby="emailSidebaroffcanvasLabel">
            <div class="card h-100 mb-0">
                <div class="card-body p-0">
                    <ul class="nav nav-tabs nav-bordered nav-justified" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#allUsers" data-bs-toggle="tab" aria-expanded="false" class="nav-link py-2 active" aria-selected="true" role="tab">
                                Amigos
                            </a>
                        </li>
                    </ul> <!-- end nav-->
                    <div class="tab-content">
                        <div class="tab-pane show active card-body pb-0" id="newpost">

                            <!-- start search box -->
                            <div class="app-search">
                                <form>
                                    <div class="mb-2 w-100 position-relative">
                                        <input type="search" class="form-control" placeholder="People, groups &amp; messages...">
                                        <span class="mdi mdi-magnify search-icon"></span>
                                    </div>
                                </form>
                            </div>
                            <!-- end search box -->
                        </div>

                        <!-- users -->
                        <div class="row">
                            <div class="col">
                                <div class="card-body chat-user-list pt-0 simplebar-scrollable-y" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px -24px -24px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px 24px 24px;">
                                    <a href="javascript:void(0);" class="text-body">
                                        <div class="online-users">
                                            <h4>Usuários Online</h4>
                                            <div id="online-users">
                                                <!-- Aqui os usuários online serão listados dinamicamente -->
                                            </div>
                                        </div>
                                    </a>

                                </div></div></div></div><div class="simplebar-placeholder" style="width: 272px; height: 834px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 443px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div> <!-- end simplebar-->
                            </div> <!-- End col -->
                        </div> <!-- end users -->
                    </div> <!-- end tab content-->
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
    </div>

<div class="col-xxl-6 col-xl-12">
    <div class="card h-100 overflow-hidden mb-0">
        <div class="card-header border-bottom">
            <div class="d-flex align-items-center gap-2">
                <div class="d-flex align-items-start me-auto">
                    <img src="assets/images/users/avatar-5.jpg" class="me-2 rounded" height="36" alt="{{ auth()->user()->name }}">
                    <div>
                        <h5 class="mt-0 mb-0 font-15">
                            <a href="pages-profile.html" class="text-reset">{{ auth()->user()->name }}</a>
                        </h5>
                        <p id="user-online-status" class="mt-1 lh-1 mb-0 text-muted font-12">
                            <small class="mdi mdi-circle text-success"></small> Online
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- chat-conversation simplebar-scrollable-y --}}
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
                                <!-- O botão de envio agora usa wire:click -->
                                <button type="submit" class="btn btn-success chat-send">
                                    <i class="uil uil-message"></i> Enviar
                                </button>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row-->
            </form>
        </div>
    </div> <!-- end card -->
</div>
</div>
{{-- <div class="col-xxl-6 col-xl-12 order-xl-2">
    <div class="card">
        <div class="card-body px-0 pb-0">
            <!-- Lista de mensagens -->
            
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

        <div class="card-body p-0">
            <div class="row">
                <div class="col">
                    <div class="mt-2 bg-light p-3">
                        <!-- Formulário para enviar novas mensagens com Livewire -->
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
                                            <!-- O botão de envio agora usa wire:click -->
                                            <button type="submit" class="btn btn-success chat-send">
                                                <i class="uil uil-message"></i> Enviar
                                            </button>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row-->
                        </form>
                    </div>
                </div> <!-- end col-->
            </div>
            <!-- end row -->
        </div>
    </div> <!-- end card -->
</div>
</div> --}}

<script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
<script>
    const socket = io('https://proconline.com.br:6001');
    //const socket = io('http://localhost:6002');
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

    // Atualizar a lista de usuários online
    socket.on('update online users', function(users) {
        let onlineUsersContainer = document.getElementById('online-users');
        onlineUsersContainer.innerHTML = '';

        users.forEach(user => {
            let userElement = document.createElement('div');
            userElement.classList.add('online-user');
            userElement.innerHTML = `
                <div class="d-flex align-items-start mt-1 p-2">
                    <img src="assets/images/users/avatar-2.jpg" class="me-2 rounded-circle" height="48" alt="${user.name}">
                    <div class="w-100 overflow-hidden">
                        <h5 class="mt-0 mb-0 font-14">
                            <span class="float-end text-muted font-12">4:30am</span>
                            ${user.name}
                        </h5>
                        <p class="mt-1 mb-0 text-muted font-14">
                            <span class="w-25 float-end text-end"><span class="badge badge-danger-lighten">3</span></span>
                            <span class="w-75">How are you today?</span>
                        </p>
                    </div>
                </div>
            `;
            onlineUsersContainer.appendChild(userElement);
        });
    });
</script>


@endsection