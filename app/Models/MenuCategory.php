<?php

namespace App\Models;

use App\Scopes\IsActiveScope;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MenuCategory extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;
    protected $fillable = ['name', 'description', 'is_active', 'deleted_at'];
    protected $appends = [
        'all_image_urls',
    ];
    protected static function booted(): void
    {
        static::addGlobalScope(new IsActiveScope);
    }

    public function menu_items()
    {
        return $this->hasMany(MenuItem::class);
    }
    protected $casts = [
        'is_active' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('category_images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->useDisk('public');
    }
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->sharpen(10);
    }
    public function getAllImageUrlsAttribute(): array
    {
        if (!$this->relationLoaded('media')) {
            $this->load('media');
        }

        return $this->getMedia('category_images')
            ->map(fn($media) => $media->getUrl())
            ->toArray();
    }
}
