<?php

namespace App\Models;

use App\Traits\HasTranslations;
use App\Traits\HasAnalytics;
use App\Traits\HasLogs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analytics extends Model
{
    use HasFactory, HasTranslations, HasLogs, HasAnalytics;

    // public function translations()
    // {
    //     return $this->morphMany(Translation::class, 'translatable');
    // }

    // public function logs()
    // {
    //     return $this->morphMany(Log::class, 'object', 'object_type', 'object_id');
    // }

    // public function user(){
    //     return $this->belongsTo(User::class);
    // }

    // public function object(){
    //     return $this->morphTo();
    // }
}
