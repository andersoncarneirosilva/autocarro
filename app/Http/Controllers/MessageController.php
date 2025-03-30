<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'sender_id' => 'required|exists:users,id',
        ]);

        $message = Message::create([
            'content' => $request->content,
            'sender_id' => $request->sender_id,
        ]);

        return response()->json($message);
    }

    public function index()
    {
        return response()->json(Message::with('user')->latest()->get());
    }
}
