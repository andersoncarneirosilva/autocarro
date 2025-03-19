<div> <!-- 🔹 Agora temos apenas um único elemento raiz -->
    
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
                    @foreach($messages as $message)
                        <li class="message {{ $message['sender_id'] == auth()->id() ? 'user-message' : 'admin-message' }}">
                            <div class="message-content">
                                <p>{{ $message['content'] }}</p>
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
                            <form wire:submit.prevent="sendMessage" class="needs-validation" novalidate name="chat-form" id="chat-form">
                                <div class="row">
                                    <div class="col mb-2 mb-sm-0">
                                        <!-- O input agora usa wire:model para se conectar ao Livewire -->
                                        <input type="text" wire:model="newMessage" class="form-control border-0"
                                               placeholder="Digite uma mensagem..." required>
                                        <div class="invalid-feedback">
                                            Please enter your message
                                        </div>
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

    @push('scripts')
<script>
    // Definindo globalmente o authUserId para garantir que ele esteja acessível no JS
    window.authUserId = @json(auth()->id());

    Livewire.on('messageUpdated', (event) => {
        console.log('Mensagem recebida ou enviada:', event);
        updateMessages(event);
    });

    // Atualizar mensagens
    function updateMessages(event) {
        console.log('Dados do evento recebidos:', event); // Verifique os dados aqui

        const messageList = document.getElementById('message-list');
        
        if (!messageList) {
            console.warn("Elemento #message-list não encontrado.");
            return;
        }

        // Criação de um novo elemento de mensagem
        const newMessage = document.createElement('li');
        
        // Adicionando a classe conforme o sender_id
        const senderClass = event.sender_id === window.authUserId ? 'user-message' : 'admin-message'; 
        newMessage.classList.add(senderClass);

        // Preenchendo o conteúdo da nova mensagem
        newMessage.innerHTML = `
        <div class="conversation-text">
            <div class="message-content">
                <p>${event.content}</p>
            </div>
            <span class="message-time">${formatDate(event.created_at)}</span>
        </div>
        `;

        // Adicionando a nova mensagem à lista
        messageList.appendChild(newMessage);
        messageList.scrollTop = messageList.scrollHeight;
    }

    // Função para formatar a data para 'H:i' (hora e minuto)
    function formatDate(dateString) {
        const createdAt = new Date(dateString);
        const formattedTime = createdAt.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        return formattedTime;
    }
</script>
@endpush


</div> <!-- 🔹 Fecha o elemento raiz -->
