<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Typing implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $user;
    public int $otherUserId;
    public bool $isTyping;

    public function __construct(User $user, int $otherUserId, bool $isTyping)
    {
        $this->user = $user;
        $this->otherUserId = $otherUserId;
        $this->isTyping = $isTyping;
    }

    public function broadcastOn(): PrivateChannel
    {
        $ids = [ $this->user->id, $this->otherUserId ];
        sort($ids);
        return new PrivateChannel('conversation.' . $ids[0] . '.' . $ids[1]);
    }

    public function broadcastAs(): string
    {
        return 'typing';
    }

    public function broadcastWith(): array
    {
        return [
            'user' => [
                'id' => $this->user->id,
                'first_name' => $this->user->first_name,
                'last_name' => $this->user->last_name,
                'name' => $this->user->name,
            ],
            'is_typing' => $this->isTyping,
        ];
    }
}
