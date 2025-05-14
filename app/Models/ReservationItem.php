<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationItem extends Model
{
    protected $fillable = [
        'reservation_id',
        'menu_item_id',
        'quantity',
        'price_at_reservation',
        'discount_amount',
        'discount_type',
        'special_instructions'
    ];
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
    public function getTotalAttribute()
    {
        $price = $this->price_at_reservation;
        $discount = $this->discount_type === 'percentage' 
            ? $price * ($this->discount_amount / 100)
            : $this->discount_amount;
            
        return ($price - $discount) * $this->quantity;
    }

}
