<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'bio',
        'password',
        'matricule',
        'avatar',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // علاقة المحادثات التي ينضم إليها المستخدم
    public function conversations()
    {
        return $this->belongsToMany(Conversation::class)->withPivot('joined_at', 'last_read_at');
    }

    // علاقة الرسائل التي أرسلها المستخدم
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // علاقة الرسائل التي استلمها المستخدم
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // علاقة الطالب
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function getNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name) ?: $this->email;
    }
}
