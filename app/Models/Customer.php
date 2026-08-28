<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = [
        'username',
        'avatar',
        'full_name',
        'email',
        'email_verified_at',
        'verification_token',
        'password',
        'phone',
        'national_id',
        'city',
        'neighborhood',
        'street',
        'building_number',
        'location_link',
        'reset_token',
        'reset_token_expires_at',
    ];

    protected $hidden = [
        'password',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    
    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class);
    }
}