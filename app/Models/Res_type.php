<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Res_type extends Model
{
    use HasFactory;

    public function places(){
        return $this->belongsToMany(Place::class,'place_res_types');
    }

    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'object', 'object_type', 'object_id');
    }

    public function analytics()
    {
        return $this->morphMany(Analytics::class, 'object', 'object_type', 'object_id');
    }
}
