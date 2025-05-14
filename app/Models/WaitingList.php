<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaitingList extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_phone',
        'reservation_date',
        'reservation_time',
        'guest_count',
        'special_requests',
        'notified'
    ];
    
    protected $casts = [
        'reservation_date' => 'date',
        'reservation_time' => 'time',
        'notified' => 'boolean'
    ];

}
