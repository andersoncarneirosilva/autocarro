<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Chat;
use App\Events\NewChatMessage;
use Illuminate\Support\Facades\Http;

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
        $chat->users()->attach([$userId, $recipientId]);
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

    $users = User::where('id', '!=', $currentUserId)
        ->with(['chats' => function($query) use ($currentUserId) {
            $query->whereHas('users', function($q) use ($currentUserId) {
                $q->where('users.id', $currentUserId);
            })->with(['messages' => function($q) {
                $q->latest()->limit(1);
            }]);
        }])
        ->get();

    $usersFormatted = $users->map(function ($user) {
        $chatWithMessage = $user->chats->first(fn($chat) => $chat->messages->isNotEmpty());
        $lastMessage = optional($chatWithMessage?->messages->first());

        return [
            'id' => $user->id,
            'name' => $user->name,
            'avatar' => $user->avatar,
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
        return response()->json(['message' => null]);
    }

    $message = $chat->messages()->with('sender')->latest()->first();


    if (!$message) {
        return response()->json(['message' => null]);
    }

    return response()->json([
        'message' => $message->content,
        'timestamp' => $message->created_at->format('Y-m-d H:i:s'),
        'sender_name' => $message->sender->name ?? 'Desconhecido'
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
        $chat->users()->attach([$userId, $recipientId]);
    }

    return response()->json(['id' => $chat->id]);
}


}
