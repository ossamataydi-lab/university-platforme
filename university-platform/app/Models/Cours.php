<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    protected $fillable = [
        'title',
        'file_path',
        'module_id',
    ];

    public function module(){
        return $this->belongsTo(Module::class);
    }
}
