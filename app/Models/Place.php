<?php

namespace App\Models;

use App\Traits\HasTranslations;
use App\Traits\HasAnalytics;
use App\Traits\HasLogs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Place extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, HasLogs, HasAnalytics;

    protected $fillable = [
        'name',
        'address',
        'phone_number',
        'type',
        'reservation_duration',
        'description',
        'photo_path',
        'is_active',
        'location'

    ];

    public function managers()
    {
        return $this->hasMany(Manager::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'place_categories');
    }

    public function res_types()
    {
        return $this->belongsToMany(Res_type::class, 'place_res_types');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function tables()
    {
        return $this->hasMany(Table::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorates()
    {
        return $this->hasMany(Favorate::class);
    }

    

    /**
     * Get latitude attribute
     */
    public function getLatitudeAttribute()
    {
        return $this->location ? (float)DB::selectOne(
            "SELECT ST_Y(location) as latitude FROM places WHERE id = ?",
            [$this->id]
        )->latitude : null;
    }

    /**
     * Get longitude attribute
     */
    public function getLongitudeAttribute()
    {
        return $this->location ? (float)DB::selectOne(
            "SELECT ST_X(location) as longitude FROM places WHERE id = ?",
            [$this->id]
        )->longitude : null;
    }

    public function setPhoneNumberAttribute($value)
    {
        $this->attributes['phone_number'] = phone($value, 'SY')->formatE164();
    }


}
