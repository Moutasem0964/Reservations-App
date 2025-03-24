<?php

namespace App\Models;

use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory, HasTranslations;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function reminders(){
        return $this->hasMany(Reminder::class);
    }

    public function survey_results(){
        return $this->hasMany(Survey_result::class,'client_id');
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function favorates(){
        return $this->hasMany(Favorate::class);
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
