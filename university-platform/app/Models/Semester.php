<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{

    protected $fillable=[
        'filiere_id',
        'semester',
    ];
    public function filier()
    {
        return $this->belongsTo(Filier::class,'filiere_id');
    }
       public function modules()
    {
        return $this->hasMany(Module::class, 'semester_id');
    }
}
