<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'image_url' => $this->image_url,
            'full_image_url' => $this->image_url ? asset('storage/' . $this->image_url) : null,
            'alt_text' => $this->alt_text,
            'sort_order' => $this->sort_order,
            'is_primary' => (bool) $this->is_primary,
            'created_at' => $this->created_at,
        ];
    }
}
