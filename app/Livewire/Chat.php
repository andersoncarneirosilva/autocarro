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
    $this->messages->push($message); // Agora a mensagem aparece sem duplicar
    Log::info('Disparando evento NewMessage!', ['message' => $message]);

    // Disparar evento WebSocket para outros navegadores
    broadcast(new NewMessage($message))->toOthers();

    // Atualizar a interface
    //$this->dispatch('newMessage', ['message' => $message]);

    $this->newMessage = '';
    $this->messages = Message::orderBy('id', 'asc')->get();
}

    




#[On('newMessage')]
public function receiveMessage($message)
{
    Log::info('Mensagem recebida no Livewire:', ['message' => $message]);

    // Certifique-se de que a mensagem tem um ID válido
    if (!isset($message['id'])) {
        Log::error('Mensagem recebida sem ID válido:', $message);
        return;
    }

    $msg = Message::find($message['id']);

    if ($msg && !$this->messages->contains('id', $msg->id)) {
        $this->messages->push($msg);
        $this->dispatch('messageUpdated', $msg); // Atualiza a interface
    }
}





    
    
    
    
    
public function addMessage($message)
{
    Log::info('Adicionando mensagem:', ['message' => $message]);

    // Adiciona a nova mensagem à lista
    $this->messages[] = $message;

    // Emitir evento para atualizar a interface
    $this->dispatch('messageUpdated', $message); 
}





    public function render()
    {
        // Ordenar as mensagens antes de renderizar
        $this->messages = $this->messages->sortBy('id');

        return view('livewire.chat');
    }
}
