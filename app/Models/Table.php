<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    use SoftDeletes;
    protected $fillable = ['number', 'capacity', 'is_active'];
    protected $casts = [
        'is_active' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    public function isAvailable($date, $time)
    {
        return !$this->reservations()
            ->where('reservation_date', $date)
            ->where('reservation_time', $time)
            ->whereIn('status', ['reserved', 'completed'])
            ->exists();
    }
    public static function availableTables($date, $time, $guests)
    {
        return self::where('is_active', true)
            ->where('capacity', '>=', $guests)
            ->withCount(['reservations' => function ($query) use ($date, $time) {
                $query->where('reservation_date', $date)
                    ->where('reservation_time', $time)
                    ->whereIn('status', ['reserved', 'completed']);
            }])
            ->having('reservations_count', 0)
            ->get();
    }
    public function scopeSearch($query, $search)
    {
        return $query->where('number', 'like', "%{$search}%")
            ->orWhere('capacity', 'like', "%{$search}%");
    }
}
