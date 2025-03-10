<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use App\Events\NewMessage;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;

class Chat extends Component
{
    public Collection $messages;
    public string $newMessage = '';
    protected $listeners = ['messageSent' => 'addMessage'];
    public function mount()
    {
        // Inicializa as mensagens, sempre ordenadas corretamente
        $this->messages = Message::orderBy('id', 'asc')->get();
    }

    public function sendMessage()
{
    if (trim($this->newMessage) === '') {
        return; // Evita mensagens vazias
    }

    // Garantir que o usuário esteja autenticado
    if (!auth()->check()) {
        return; // Se não estiver autenticado, não envia mensagem
    }

    // Criar a nova mensagem no banco, incluindo o sender_id
    $message = Message::create([
        'content' => $this->newMessage,
        'sender_id' => auth()->id(), // Associa o usuário autenticado à mensagem
    ]);

    // Disparar evento WebSocket para outros navegadores
    broadcast(new NewMessage($message))->toOthers();

    // Disparar evento Livewire para atualizar a interface
    $this->dispatch('messageSent', message: $message->toArray());

    // Limpar o campo de entrada
    $this->newMessage = '';

    // Atualizar a lista de mensagens novamente com a nova mensagem
    $this->messages = Message::orderBy('id', 'asc')->get();
}



    #[On('messageSent')]
    public function receiveMessage($message)
    {
        // Buscar a mensagem no banco e garantir que não seja duplicada
        $msg = Message::find($message['id']);

        if ($msg && !$this->messages->contains('id', $msg->id)) {
            // Adicionar nova mensagem ao final da lista ordenada
            $this->messages->push($msg);
        }
    }

    public function addMessage($message)
    {
        // Adiciona a nova mensagem à lista
        $this->messages[] = $message;

        // Emitir evento para aplicar formatação no frontend, se necessário
        $this->emit('messageUpdated');
    }

    public function render()
    {
        // Ordenar as mensagens antes de renderizar
        $this->messages = $this->messages->sortBy('id');

        return view('livewire.chat');
    }
}
