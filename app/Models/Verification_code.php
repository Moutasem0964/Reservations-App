<?php

namespace App\Models;

use App\Traits\HasTranslations;
use App\Traits\HasAnalytics;
use App\Traits\HasLogs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Verification_code extends Model
{
    use HasFactory, SoftDeletes, HasLogs, HasAnalytics;

    protected $fillable = [
        'user_id',
        'code',
        'code_type',
        'expires_at',
        'is_verified'
    ];
    protected $casts = [
        'expires_at' => 'datetime',
        'is_verified' => 'boolean'
    ];

    public function scopeValid($query)
    {
        return $query->where('expires_at', '>', now())
            ->where('is_verified', false);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('code_type', $type);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
