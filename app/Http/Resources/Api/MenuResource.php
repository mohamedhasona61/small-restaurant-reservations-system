<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'daily_availability' => $this->daily_availability,
            'current_availability' => $this->current_availability,
            'discount_amount' => $this->discount_amount,
            'discount_type' => $this->discount_type,
            'discount_start_at' => optional($this->discount_start_at)->format('Y-m-d'),
            'discount_end_at' => optional($this->discount_end_at)->format('Y-m-d'),
            'is_active' => $this->is_active,
            'category_id' => $this->category_id,
            'category_name' => $this->menu_category?->name,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'images' => $this->all_image_urls,
        ];
    }
}
