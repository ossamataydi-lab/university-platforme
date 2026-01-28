<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
   protected $fillable=['exercise_id','user_id','file_path','garde','feedback'];
   public function exercice(){
    return $this->belongsTo(Exercise::class);
   }

   public function user(){
    return $this->belongsTo(User::class,'user_id');
   }
}
