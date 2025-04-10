<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ManagerInvitation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable=[
        'user_id',
        'place_id',
        'phone_number',
        'token',
        'expires_at'
    ];
    
}
