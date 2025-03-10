<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    //
    public function index()
    {

        // return $events;
        return view('chat.index');
    }
}
