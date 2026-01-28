<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'conversation_id',
        'message',
        'is_read',
        'attachment_path',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function conversations()
    {
        return $this->belongsTo(Conversation::class, 'conversation_user', 'user_id', 'conversation_id');
    }


    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function statuses()
    {
        return $this->hasMany(MessageStatus::class);
    }
}
