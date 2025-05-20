<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'reservation_id',
        'payment_option',
        'amount',
        'tax',
        'service_charge',
        'total_amount',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
