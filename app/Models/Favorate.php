<?php

namespace App\Models;

use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorate extends Model
{
    use HasFactory, HasTranslations;

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function place(){
        return $this->belongsTo(Place::class);
    }

    // public function translations()
    // {
    //     return $this->morphMany(Translation::class, 'translatable');
    // }

    public function logs()
    {
        return $this->morphMany(Log::class, 'object', 'object_type', 'object_id');
    }

    public function analytics()
    {
        return $this->morphMany(Analytics::class, 'object', 'object_type', 'object_id');
    }
}
