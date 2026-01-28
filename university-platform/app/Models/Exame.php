<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exame extends Model
{
    protected $fillable = [
        'title',
        'description',
        'module_id',
        'file_path',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }
}
