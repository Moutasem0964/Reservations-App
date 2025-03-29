<?php

namespace App\Models;

use App\Traits\HasTranslations;
use App\Traits\HasAnalytics;
use App\Traits\HasLogs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory, HasTranslations, HasLogs, HasAnalytics;

    protected $fillable = ['translatable_type', 'translatable_id', 'field', 'value'];

    public function translatable()
    {
        return $this->morphTo();
    }

    // public function logs()
    // {
    //     return $this->morphMany(Log::class, 'object', 'object_type', 'object_id');
    // }

    // public function analytics()
    // {
    //     return $this->morphMany(Analytics::class, 'object', 'object_type', 'object_id');
    // }
}
