<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Chat;
use App\Events\NewChatMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{

    public function index(){
    // Pegando as mensagens ordenadas do mais antigo para o mais recente
    $messages = Message::orderBy('created_at', 'asc')->get();
    //dd($messages);
    return view('chat.index', compact('messages'));
}
public function createOrGetChat(Request $request)
{
    $request->validate(['recipient_id' => 'required|exists:users,id']);

    $userId = auth()->id();
    $recipientId = $request->recipient_id;

    $chat = Chat::whereHas('users', fn($q) => $q->where('users.id', $userId))
                ->whereHas('users', fn($q) => $q->where('users.id', $recipientId))
                ->first();

                if (!$chat) {
                    $chat = Chat::create();
                    $chat->users()->attach([
                        $userId => ['last_read_at' => now()],
                        $recipientId => ['last_read_at' => now()],
                    ]);
                }
                

    return response()->json(['id' => $chat->id]);
}



public function getMessages($chatId)
{
    $messages = Message::with('sender')
        ->where('chat_id', $chatId)
        ->orderBy('created_at')
        ->get()
        ->map(function ($msg) {
            return [
                'id' => $msg->id,
                'chat_id' => $msg->chat_id,
                'content' => $msg->content,
                'sender_id' => $msg->sender_id,
                'sender_name' => $msg->sender->name ?? 'Desconhecido',
                'timestamp' => $msg->created_at->format('H:i'),
            ];
        });

    return response()->json($messages);
}


public function sendMessage(Request $request)
{
    $request->validate([
        'chat_id' => 'required|exists:chats,id',
        'message' => 'required|string',
        'sender_id' => 'required|exists:users,id', // adiciona validação do sender
    ]);

    $message = Message::create([
        'chat_id' => $request->chat_id,
        'sender_id' => $request->sender_id,
        'content' => $request->message,
    ]);

    $message->load('sender');

    return response()->json([
        'message' => [
            'id' => $message->id,
            'chat_id' => $message->chat_id,
            'content' => $message->content,
            'sender_id' => $message->sender_id,
            'created_at' => $message->created_at,
            'sender' => [
                'id' => $message->sender->id,
                'name' => $message->sender->name,
            ]
        ]
    ], 201);
}


public function getOnlineUsers()
{
    $currentUserId = auth()->id();

    $users = \App\Models\User::where('id', '!=', $currentUserId)
        ->with(['chats' => function($query) use ($currentUserId) {
            $query->whereHas('users', function($q) use ($currentUserId) {
                $q->where('users.id', $currentUserId);
            })
            ->with(['messages' => function($q) {
                $q->latest()->limit(1);
            }]);
        }])
        ->get();

    $usersFormatted = $users->map(function ($user) use ($currentUserId) {
        $chatWithMessage = $user->chats->first(fn($chat) => $chat->messages->isNotEmpty());
        $lastMessage = optional($chatWithMessage?->messages->first());

        // Verifica se há um chat entre os dois usuários
        $chat = $chatWithMessage;
        $unreadCount = 0;

        if ($chat) {
            // Pega a data de leitura do usuário atual
            $pivot = $chat->users->find($currentUserId)?->pivot;
            $lastReadAt = optional($pivot)->last_read_at;

            // Conta mensagens do outro usuário, após o last_read_at
            $unreadCount = $chat->messages()
                ->where('sender_id', $user->id)
                ->when($lastReadAt, function ($query) use ($lastReadAt) {
                    $query->where('created_at', '>', $lastReadAt);
                })
                ->count();
        }

        return [
            'id' => $user->id,
            'name' => $user->name,
            'avatar' => $user->avatar,
            'unread_count' => $unreadCount,
            'last_message' => $lastMessage ? [
                'content' => $lastMessage->content,
                'created_at' => $lastMessage->created_at->format('H:i')
            ] : null,
        ];
    });

    return response()->json($usersFormatted);
}






public function lastMessage(Request $request)
{
    $userId = $request->query('user_id');
    $recipientId = $request->query('recipient_id');
    
    if (!$userId || !$recipientId) {
        return response()->json(['message' => 'Parâmetros ausentes'], 400);
    }

    // Buscar o chat entre os dois usuários (assumindo que só existe um)
    $chat = \App\Models\Chat::whereHas('users', function ($query) use ($userId) {
        $query->where('chat_user.user_id', $userId);
    })->whereHas('users', function ($query) use ($recipientId) {
        $query->where('chat_user.user_id', $recipientId);
    })->first();
    
    if (!$chat) {
        return response()->json([
            'message' => null,
            'timestamp' => null,
            'sender_name' => null,
            'unread_count' => 0
        ]);
    }

    $message = $chat->messages()->with('sender')->latest()->first();

    if (!$message) {
        return response()->json([
            'message' => null,
            'timestamp' => null,
            'sender_name' => null,
            'unread_count' => 0
        ]);
    }

    // Contar as mensagens não lidas para o usuário
    $unreadCount = $chat->messages()
        ->where('sender_id', $recipientId)
        ->where('created_at', '>', function ($query) use ($chat, $userId) {
            $query->select('last_read_at')
                  ->from('chat_user')
                  ->where('chat_id', $chat->id)
                  ->where('user_id', $userId);
        })
        ->count();

    // Log para verificar a quantidade de mensagens não lidas
    Log::info('Contagem de mensagens não lidas para o usuário ' . $userId . ': ' . $unreadCount);

    return response()->json([
        'message' => $message->content,
        'timestamp' => $message->created_at->format('Y-m-d H:i:s'),
        'sender_name' => $message->sender->name ?? 'Desconhecido',
        'unread_count' => $unreadCount
    ]);
}

public function getChat(Request $request)
{
    $userId = auth()->id();
    $recipientId = $request->input('recipient_id');

    if (!$recipientId) {
        return response()->json(['error' => 'ID do destinatário ausente'], 400);
    }

    $chat = Chat::whereHas('users', fn($q) => $q->where('users.id', $userId))
                ->whereHas('users', fn($q) => $q->where('users.id', $recipientId))
                ->first();

                if (!$chat) {
                    $chat = Chat::create();
                    $chat->users()->attach([
                        $userId => ['last_read_at' => now()],
                        $recipientId => ['last_read_at' => now()],
                    ]);
                }
                

    return response()->json(['id' => $chat->id]);
}

public function markAsRead(Request $request)
{
    $chatId = $request->chat_id;
    $userId = auth()->id();

    DB::table('chat_user')
        ->where('chat_id', $chatId)
        ->where('user_id', $userId)
        ->update(['last_read_at' => now()]);

    return response()->json(['status' => 'ok']);
}


}
