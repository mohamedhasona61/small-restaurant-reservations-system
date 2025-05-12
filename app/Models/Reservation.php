<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'table_id',
        'customer_name',
        'customer_phone',
        'reservation_date',
        'reservation_time',
        'guest_count',
        'special_requests',
        'status'
    ];
    protected $casts = [
        'reservation_date' => 'date',
        'reservation_time' => 'time',
        'guest_count' => 'integer',
    ];
    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}
