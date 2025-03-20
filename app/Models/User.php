<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    public function manager(){
        return $this->hasOne(Manager::class);
    }

    public function employee(){
        return $this->hasOne(Employee::class);
    }

    public function client(){
        return $this->hasOne(Client::class);
    }

    public function admin(){
        return $this->hasOne(Admin::class);
    }

    public function getRoleAttribute(){
    if ($this->client) {
        return 'client';
    } elseif ($this->manager) {
        return 'manager';
    } elseif ($this->employee) {
        return 'employee';
    } elseif ($this->admin) {
        return 'admin';
    }
    return 'unknown'; // Default if the user has no role
}


    public function verificationCodes()
    {
        return $this->hasMany(Verification_code::class);
    }

    public function reservations(){
        return $this->hasMany(Reservation::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function logs(){
        return $this->hasMany(Log::class);
    }

    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function analytics()
    {
        return $this->hasMany(Analytics::class);
    }
}
