<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    protected $fillable = ['customer_id', 'token'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}