<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // List conversations for the logged-in user
    public function index()
    {
        $user = Auth::user();

        $conversations = Conversation::with(['userOne', 'userTwo', 'messages'])
            ->where('user_one_id', $user->id)
            ->orWhere('user_two_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('panel.pages.chat', compact('conversations', 'user'));
    }

    // Show list of all registered users to start a chat with
    public function userList()
    {
        $user = Auth::user();

        $users = User::where('id', '!=', $user->id)
            ->orderBy('name')
            ->get();

        return view('panel.pages.chat_users', compact('users', 'user'));
    }

    // Open a specific conversation
    public function show($id)
    {
        $user = Auth::user();

        $conversation = Conversation::with(['messages.user', 'userOne', 'userTwo'])
            ->findOrFail($id);

        if ($conversation->user_one_id !== $user->id && $conversation->user_two_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $messages = $conversation->messages()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('panel.pages.chat_room', compact('conversation', 'messages', 'user'));
    }

    // Start (or open existing) conversation with a chosen user
    public function startConversation($targetUserId)
    {
        $user = Auth::user();

        if ((int) $targetUserId === $user->id) {
            return redirect()->route('chat.users')->with('error', 'You cannot chat with yourself.');
        }

        $target = User::findOrFail($targetUserId);

        $existing = Conversation::where(function ($q) use ($user, $target) {
                $q->where('user_one_id', $user->id)->where('user_two_id', $target->id);
            })
            ->orWhere(function ($q) use ($user, $target) {
                $q->where('user_one_id', $target->id)->where('user_two_id', $user->id);
            })
            ->first();

        if ($existing) {
            return redirect()->route('chat.show', $existing->id);
        }

        $conversation = Conversation::create([
            'user_one_id' => $user->id,
            'user_two_id' => $target->id,
        ]);

        return redirect()->route('chat.show', $conversation->id);
    }

    // Send a message
    public function send(Request $request, $conversationId)
    {
        $request->validate(['body' => 'required|string|max:1000']);

        $user = Auth::user();
        $conversation = Conversation::findOrFail($conversationId);

        if ($conversation->user_one_id !== $user->id && $conversation->user_two_id !== $user->id) {
            abort(403);
        }

        Message::create([
            'conversation_id' => $conversationId,
            'user_id' => $user->id,
            'body' => $request->body,
        ]);

        $conversation->touch();

        return redirect()->back();
    }

    // Polling — fetch latest 3 messages for the header dropdown
    public function latestHeader(Request $request)
    {
        $user = Auth::user();

        $messages = Message::with(['user', 'conversation.userOne', 'conversation.userTwo'])
            ->whereHas('conversation', function ($q) use ($user) {
                $q->where('user_one_id', $user->id)
                  ->orWhere('user_two_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get()
            ->map(function ($msg) use ($user) {
                $other = $msg->conversation->otherUser($user->id);
                return [
                    'id' => $msg->id,
                    'conversation_id' => $msg->conversation_id,
                    'body' => $msg->body,
                    'user_name' => $msg->user->name,
                    'user_image' => $other->user_image ?? null,
                    'is_mine' => $msg->user_id === $user->id,
                    'time' => $msg->created_at->diffForHumans(),
                    'created_at' => $msg->created_at->toIso8601String(),
                ];
            })
            ->values();

        return response()->json($messages);
    }

    // Polling — fetch new messages
    public function fetch(Request $request, $conversationId)
    {
        $user = Auth::user();
        $lastId = $request->query('last_id', 0);

        $conversation = Conversation::findOrFail($conversationId);

        if ($conversation->user_one_id !== $user->id && $conversation->user_two_id !== $user->id) {
            abort(403);
        }

        $messages = Message::with('user')
            ->where('conversation_id', $conversationId)
            ->where('id', '>', $lastId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'body' => $msg->body,
                    'user_id' => $msg->user_id,
                    'user_name' => $msg->user->name,
                    'created_at' => $msg->created_at->format('h:i A'),
                    'is_mine' => $msg->user_id === auth()->id(),
                ];
            });

        return response()->json($messages);
    }
}