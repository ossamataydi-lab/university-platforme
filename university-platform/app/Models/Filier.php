<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filier extends Model
{
 protected $table = 'filieres';

   protected $fillable = ['name','description'];

   public function modules()
   {
       return $this->hasMany(Module::class, 'filiere_id');
   }
   public function students(){
       return $this->hasMany(Student::class,'filiere_id');
   }

   public function user(){
     return $this->belongsTo(User::class,'user_id');
   }
   public function semesters(){
    return $this->hasMany(Semester::class, 'filiere_id');
   }
}

