<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'service_id',
         'customer_id',
        'full_name',
        'phone',
        'national_id',
        'email',
        'city',
        'neighborhood',
        'street',
        'building_number',
        'map_link',
        'notes',
        'service_options',
        'status',
        'cancelled_by',
        'payment_method',
        'payment_status',
        'amount_paid',
    ];

    // هاد بيخلي Laravel يحول service_options أوتوماتيكياً
    // من/إلى array بدل ما تتعاملي معه كنص JSON يدوياً
    protected $casts = [
        'service_options' => 'array',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}