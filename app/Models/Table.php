<?php

namespace App\Models;

use App\Traits\HasTranslations;
use App\Traits\HasAnalytics;
use App\Traits\HasLogs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory, HasTranslations, HasLogs, HasAnalytics;

    public function place(){
        return $this->belongsTo(Place::class);
    }

    public function reservations(){
        return $this->hasMany(Reservation::class);
    }

    // public function translations()
    // {
    //     return $this->morphMany(Translation::class, 'translatable');
    // }

    // public function logs()
    // {
    //     return $this->morphMany(Log::class, 'object', 'object_type', 'object_id');
    // }

    // public function analytics()
    // {
    //     return $this->morphMany(Analytics::class, 'object', 'object_type', 'object_id');
    // }
}
