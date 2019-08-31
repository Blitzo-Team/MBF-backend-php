<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'permissions'
    ];
    protected $hidden = [
        'password', 'verification_code', 'forgot_password_date', 'forgot_password_code'
    ];
    protected $casts = [
        'is_disabled' => 'boolean',
        'permissions' => 'array'
    ];
    protected $appends = [
        'status'
    ];

    public function getStatusAttribute()
    {
        return $this->is_disabled? 'Disabled': 'Active';
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
