<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Conversation;
use App\Models\MessageStatus;
use App\Events\MessageSent;
use App\Events\Typing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    /**
     * Chat index: list of all users (except self).
     * Each user has: lastMessage, last_message_time, unread_count.
     */
    public function index()
    {
        $authId = Auth::id();

        $users = User::where('id', '!=', $authId)
            ->get()
            ->map(function ($user) use ($authId) {
                $lastMessage = Message::where(function ($q) use ($user, $authId) {
                    $q->where('sender_id', $authId)->where('receiver_id', $user->id);
                })->orWhere(function ($q) use ($user, $authId) {
                    $q->where('sender_id', $user->id)->where('receiver_id', $authId);
                })
                    ->orderBy('created_at', 'desc')
                    ->with('sender')
                    ->first();

                $unreadCount = Message::where('sender_id', $user->id)
                    ->where('receiver_id', $authId)
                    ->where('is_read', false)
                    ->count();

                $user->lastMessage = $lastMessage;
                $user->last_message_time = $lastMessage?->created_at;
                $user->unread_count = $unreadCount;

                return $user;
            })
            ->sortByDesc(fn ($u) => $u->last_message_time?->timestamp ?? 0)
            ->values();

        return view('messages.index', compact('users'));
    }

    public function chat($id)
    {
        $receiver = User::findOrFail($id);
        $messages = Message::where(function ($q) use ($id) {
            $q->where('sender_id', Auth::id())->where('receiver_id', $id);
        })->orWhere(function ($q) use ($id) {
            $q->where('sender_id', $id)->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->with('sender')->get();

        $this->markConversationAsRead($id);

        return view('messages.chat', compact('receiver', 'messages'));
    }

    /**
     * API: paginated messages for a conversation. Marks as read when loading.
     */
    public function receive(Request $request, $id)
    {
        $authId = Auth::id();
        $perPage = 20;
        $page = max(1, (int) $request->get('page', 1));

        $query = Message::where(function ($q) use ($authId, $id) {
            $q->where('sender_id', $authId)->where('receiver_id', (int) $id);
        })->orWhere(function ($q) use ($authId, $id) {
            $q->where('sender_id', (int) $id)->where('receiver_id', $authId);
        });

        $messages = $query->with('sender')
            ->orderBy('created_at', 'desc')
            ->skip(($page - 1) * $perPage)
            ->take($perPage + 1)
            ->get();

        $hasMore = $messages->count() > $perPage;
        if ($hasMore) {
            $messages->pop();
        }
        $messages = $messages->reverse()->values();

        $this->markConversationAsRead($id);

        $payload = $messages->map(function ($m) {
            $out = [
                'id' => $m->id,
                'message' => $m->message,
                'sender_id' => $m->sender_id,
                'receiver_id' => $m->receiver_id,
                'created_at' => $m->created_at,
                'is_read' => $m->is_read,
                'attachment_path' => $m->attachment_path,
                'sender' => $m->sender,
            ];
            if ($m->attachment_path) {
                $out['attachment_url'] = Storage::url($m->attachment_path);
            }
            return $out;
        });

        return response()->json([
            'messages' => $payload,
            'has_more' => $hasMore,
            'current_page' => $page,
        ]);
    }

    /**
     * Mark all messages from user $otherUserId to me as read.
     */
    protected function markConversationAsRead(int $otherUserId): void
    {
        $authId = Auth::id();
        $messageIds = Message::where('sender_id', $otherUserId)
            ->where('receiver_id', $authId)
            ->where('is_read', false)
            ->pluck('id');

        if ($messageIds->isEmpty()) {
            return;
        }

        Message::whereIn('id', $messageIds)->update(['is_read' => true]);
        MessageStatus::whereIn('message_id', $messageIds)
            ->where('user_id', $authId)
            ->update(['status' => 'read', 'read_at' => now()]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'nullable|string|max:1000',
        ]);

        if (empty($request->message) && ! $request->hasFile('attachment')) {
            return response()->json(['error' => 'Message or attachment is required'], 422);
        }

        $conversation = Conversation::where('type', 'private')
            ->whereHas('users', fn ($q) => $q->where('user_id', Auth::id()))
            ->whereHas('users', fn ($q) => $q->where('user_id', $request->receiver_id))
            ->withCount('users')
            ->having('users_count', '=', 2)
            ->first();

        if (! $conversation) {
            $conversation = Conversation::create([
                'type' => 'private',
                'created_by' => Auth::id(),
            ]);
            $conversation->users()->attach([Auth::id(), $request->receiver_id]);
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments');
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'conversation_id' => $conversation->id,
            'message' => $request->message ?? '',
            'is_read' => false,
            'attachment_path' => $attachmentPath,
        ]);

        foreach ($conversation->users as $user) {
            MessageStatus::create([
                'message_id' => $message->id,
                'user_id' => $user->id,
                'status' => $user->id === Auth::id() ? 'sent' : 'delivered',
            ]);
        }

        $message->load('sender');
        broadcast(new MessageSent($message))->toOthers();

        $out = [
            'id' => $message->id,
            'message' => $message->message,
            'sender_id' => $message->sender_id,
            'receiver_id' => $message->receiver_id,
            'created_at' => $message->created_at,
            'is_read' => $message->is_read,
            'attachment_path' => $message->attachment_path,
            'sender' => $message->sender,
        ];
        if ($message->attachment_path) {
            $out['attachment_url'] = Storage::url($message->attachment_path);
        }
        return response()->json($out);
    }

    /**
     * Typing indicator. Expects receiver_id, is_typing. Broadcasts on conversation channel.
     */
    public function typing(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'is_typing' => 'required|boolean',
        ]);

        broadcast(new Typing(Auth::user(), (int) $request->receiver_id, $request->boolean('is_typing')))->toOthers();

        return response()->json(['status' => 'ok']);
    }

    /**
     * Mark messages from user $id (other user) to me as read.
     */
    public function markAsRead(Request $request, $id)
    {
        $this->markConversationAsRead((int) $id);

        return response()->json(['status' => 'ok']);
    }
}
