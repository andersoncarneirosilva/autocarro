<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use App\Events\NewMessage;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Log;

class Chat extends Component
{
    public Collection $messages;
    public string $newMessage = '';
    protected $listeners = ['newMessage' => 'addMessage'];

    public function mount()
    {
        // Inicializa as mensagens, sempre ordenadas corretamente
        $this->messages = Message::orderBy('id', 'asc')->get();
    }

    public function sendMessage()
{
    if (trim($this->newMessage) === '') {
        return;
    }

    if (!auth()->check()) {
        return;
    }

    // Criar a nova mensagem
    $message = Message::create([
        'content' => $this->newMessage,
        'sender_id' => auth()->id(),
    ]);

    // Adicionar log antes do evento
    Log::info('📩 Mensagem criada!', ['message' => $message]);

    // Disparar evento WebSocket para outros navegadores
    Log::info('📡 Disparando evento NewMessage!');
    broadcast(new NewMessage($message));
    Log::info('✅ Evento NewMessage disparado!');

    // Atualizar a interface
    $this->newMessage = '';
    $this->messages = Message::orderBy('id', 'asc')->get();
}


    #[On('newMessage')]
    public function receiveMessage($message)
    {
        Log::info('Mensagem recebida no Livewire:', ['message' => $message]);

        // Verifique se o ID da mensagem é válido antes de buscar
        if (!isset($message['id'])) {
            Log::error('Mensagem recebida sem ID válido:', $message);
            return;
        }

        $msg = Message::find($message['id']);

        if ($msg && !$this->messages->contains('id', $msg->id)) {
            $this->messages->push($msg);
            Log::info('Disparando evento messageUpdated', ['message' => $msg]);
            $this->dispatch('messageUpdated', $msg); // Atualiza a interface com a nova mensagem
            $this->dispatch('$refresh'); // Força a atualização do Livewire
        }
    }

    public function addMessage($message)
{
    Log::info('Adicionando mensagem:', ['message' => $message]);

    // Adicionar a nova mensagem à lista de mensagens do componente
    $this->messages->push($message);

    // Emitir evento para atualizar a interface
    $this->dispatch('messageUpdated', $message);
}

    public function render()
    {
        return view('livewire.chat', [
            'messages' => Message::orderBy('id', 'asc')->get(),
        ]);
    }
}
