<?php

namespace App\Models;

use App\Scopes\IsActiveScope;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItem extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;
    protected $guarded = ['id'];
    protected $casts = [
        'is_active' => 'boolean',
        'deleted_at' => 'datetime',
    ];
    protected static function booted(): void
    {
        static::addGlobalScope(new IsActiveScope);
        static::creating(function (self $item) {
            $item->current_availability = $item->daily_availability;
        });
    }
    protected $appends = [
        'all_image_urls',
    ];
    public function scopeAvailable($query)
    {
        return $query->where('current_availability', '>', 0);
    }
    public function reservationItems()
    {
        return $this->hasMany(ReservationItem::class);
    }
    public function menu_category()
    {
        return $this->belongsTo(MenuCategory::class, 'category_id')
            ->withTrashed();
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('menu_images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->useDisk('public');
    }
    public function getAllImageUrlsAttribute(): array
    {
        if (!$this->relationLoaded('media')) {
            $this->load('media');
        }
        return $this->getMedia('menu_images')
            ->map(fn($media) => $media->getUrl())
            ->toArray();
    }
}
