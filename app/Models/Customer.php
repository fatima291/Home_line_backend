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
    ];

    protected $hidden = [
        'password',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    
}