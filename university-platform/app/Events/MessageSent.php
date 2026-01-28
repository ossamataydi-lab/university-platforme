<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message->load('sender');
    }

    public function broadcastOn(): PrivateChannel
    {
        $ids = [$this->message->sender_id, $this->message->receiver_id];
        sort($ids);
        return new PrivateChannel('conversation.' . $ids[0] . '.' . $ids[1]);
    }

    public function broadcastAs(): string
    {
        return 'MessageSent';
    }

    public function broadcastWith(): array
    {
        $data = [
            'id' => $this->message->id,
            'message' => $this->message->message,
            'sender_id' => $this->message->sender_id,
            'receiver_id' => $this->message->receiver_id,
            'created_at' => $this->message->created_at,
            'attachment_path' => $this->message->attachment_path,
            'is_read' => $this->message->is_read,
            'sender' => $this->message->sender,
        ];
        if ($this->message->attachment_path) {
            $data['attachment_url'] = Storage::url($this->message->attachment_path);
        }
        return ['message' => $data];
    }
}
