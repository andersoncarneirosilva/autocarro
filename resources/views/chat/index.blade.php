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
<div class="col-xxl-6 col-xl-12 order-xl-2">
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
</div>

<script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
<script>
    const socket = io('https://proconline.com.br:6002');
    const userId = @json(auth()->id()); // Corrigido para evitar erro com usuários não autenticados

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

    // Definir a classe para a mensagem de acordo com o tipo (usuário ou admin)
    let messageClass = (msg.user && msg.user.id === userId) ? 'user-message' : 'admin-message';

    li.classList.add('message', messageClass);  // Adicionando as classes de estilo
    const now = new Date();

// Obtém a hora e o minuto
const hours = now.getHours();  // Hora (0-23)
const minutes = now.getMinutes();  // Minutos (0-59)

// Adiciona um zero à esquerda se a hora ou o minuto for menor que 10
const formattedTime = `${hours < 10 ? '0' : ''}${hours}:${minutes < 10 ? '0' : ''}${minutes}`;


    // Definir o conteúdo da mensagem com base no usuário
    let content = `
        <div class="message-content">
            <strong>${msg.user ? msg.user.name : 'Usuário desconhecido'}:</strong> 
            ${msg.content}
        </div>
        <span class="message-time">${formattedTime}</span> <!-- Correção para usar msg.sent_at -->
    `;

    li.innerHTML = content;  // Inserir o conteúdo da mensagem

    messageList.appendChild(li);
    messageList.scrollTop = messageList.scrollHeight; // Scroll automático para a última mensagem
});


</script>

@endsection