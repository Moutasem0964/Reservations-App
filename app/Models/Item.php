<?php

namespace App\Models;

use App\Traits\HasTranslations;
use App\Traits\HasAnalytics;
use App\Traits\HasLogs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory, HasTranslations, HasLogs, HasAnalytics;

    protected $fillable=[
        'menu_id',
        'name',
        'description',
        'price',
        'available',
        'photo'
    ];

    public function menu(){
        return $this->belongsTo(Menu::class);
    }
}
