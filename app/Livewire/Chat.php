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
        return;
    }

    if (!auth()->check()) {
        return;
    }

    $message = Message::create([
        'content' => $this->newMessage,
        'sender_id' => auth()->id(),
    ]);

    // Capturar o socket_id diretamente da requisição
    $socketId = request()->header('X-Socket-ID');

    if (!$socketId || $socketId === 'undefined') {
        \Log::error('Socket ID não foi recebido corretamente');
    } else {
        \Log::info('Socket ID válido:', ['socket_id' => $socketId]);
    }

    // Enviar o evento de mensagem, excluindo o usuário que enviou
    broadcast(new NewMessage($message))->toOthers();

    $this->dispatch('messageSent', message: $message->toArray());

    $this->newMessage = '';
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
