<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'name',
        'type',
        'created_by',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('joined_at', 'last_read_at');
    }

    

  public function messages()
{
    return $this->hasMany(Message::class);
}

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
