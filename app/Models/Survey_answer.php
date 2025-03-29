<?php

namespace App\Models;

use App\Traits\HasTranslations;
use App\Traits\HasAnalytics;
use App\Traits\HasLogs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey_answer extends Model
{
    use HasFactory, HasTranslations, HasLogs, HasAnalytics;

    public function question(){
        return $this->belongsTo(Survey_question::class,'question_id');
    }

    public function results(){
        return $this->hasMany(Survey_result::class,'answer_id');
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
