<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Student extends Model
{
    use Notifiable;

    protected $fillable = [
        'user_id',
        'filiere_id',
        'semester_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function filier(){
        return $this->belongsTo(Filier::class, 'filiere_id');
    }

    public function semester(){
        return $this->belongsTo(Semester::class, 'semester_id');
    }
}
