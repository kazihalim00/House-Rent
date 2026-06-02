<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Show the chat page
    public function index()
    {
        $messages = Message::with('user')
                        ->orderBy('created_at', 'asc')
                        ->get();

        return view('panel.pages.chat', compact('messages'));
    }

    // Save a new message (called when user hits Send)
    public function send(Request $request)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        Message::create([
            'user_id' => Auth::id(),
            'body'    => $request->body,
        ]);

        return redirect()->back();
    }

    // This is called by JavaScript every 3 seconds to get new messages
    public function fetch(Request $request)
    {
        $lastId = $request->query('last_id', 0);

        $messages = Message::with('user')
                        ->where('id', '>', $lastId)
                        ->orderBy('created_at', 'asc')
                        ->get()
                        ->map(function ($msg) {
                            return [
                                'id'         => $msg->id,
                                'body'       => $msg->body,
                                'user_id'    => $msg->user_id,
                                'user_name'  => $msg->user->name,
                                'created_at' => $msg->created_at->format('h:i A'),
                                'is_mine'    => $msg->user_id === auth()->id(),
                            ];
                        });

        return response()->json($messages);
    }
}