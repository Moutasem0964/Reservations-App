<?php

namespace App\Models;

use App\Traits\HasTranslations;
use App\Traits\HasAnalytics;
use App\Traits\HasLogs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey_question extends Model
{
    use HasFactory, HasTranslations, HasLogs, HasAnalytics;

    public function survey_answers(){
        return $this->hasMany(Survey_answer::class,'question_id');
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
