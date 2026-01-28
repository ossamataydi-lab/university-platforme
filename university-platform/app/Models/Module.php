<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{

    //rm TODO.md
    protected $fillable = [
        'name',
        'description',
        'chaine',
        'teatcher_name',
        'filiere_id',
        'semester_id',
    ];
    public function filiere()
    {
        return $this->belongsTo(Filier::class, 'filiere_id');
    }
    public function exames()
    {
        return $this->hasMany(Exame::class, 'module_id');
    }

    public function courses()
    {
        return $this->hasMany(Cours::class, 'module_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function exercises()
    {
        return $this->hasMany(Exercise::class, 'module_id');
    }
}
