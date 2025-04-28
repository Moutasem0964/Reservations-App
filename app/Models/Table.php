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

    protected $fillable=[
        'place_id',
        'number',
        'capacity',
        'status'
    ];

    public function place(){
        return $this->belongsTo(Place::class);
    }

    public function reservations(){
        return $this->hasMany(Reservation::class);
    }

    public function photos(){
        return $this->hasMany(TablePhoto::class);
    }

}
