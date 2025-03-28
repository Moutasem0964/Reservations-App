<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    use HasFactory, SoftDeletes;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function loggable()
    {
        return $this->morphTo('object', 'object_type', 'object_id');
    }

    public function analytics()
    {
        return $this->morphMany(Analytics::class, 'object', 'object_type', 'object_id');
    }
}
