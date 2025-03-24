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
    
    protected $listeners = ['newMessageReceived' => 'addMessage'];

    public function mount()
    {
        $this->messages = Message::orderBy('id', 'asc')->get();
    }

    public function sendMessage()
    {
        if (trim($this->newMessage) === '' || !auth()->check()) {
            return;
        }

        $message = Message::create([
            'content' => $this->newMessage,
            'sender_id' => auth()->id(),
        ]);

        Log::info('📡 Disparando evento NewMessage!', ['message' => $message]);
        broadcast(new NewMessage($message));
        Log::info('✅ Evento NewMessage disparado!');

        $this->newMessage = '';
        $this->messages = Message::orderBy('id', 'asc')->get();
    }

    #[On('newMessageReceived')]
    public function addMessage($message)
    {
        Log::info('🆕 Nova mensagem recebida:', ['message' => $message]);

        $msg = Message::find($message['id']);

        if ($msg && !$this->messages->contains('id', $msg->id)) {
            $this->messages->push($msg);
            $this->dispatch('messageUpdated', $msg);
            $this->dispatch('$refresh');
        }
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
