<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'category_id' => $this->category_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'barcode' => $this->barcode,
            'short_description' => $this->short_description,
            'long_description' => $this->long_description,
            'price' => (float) $this->price,
            'discount_price' => $this->discount_price ? (float) $this->discount_price : null,
            'stock' => (int) $this->stock,
            'weight' => $this->weight ? (float) $this->weight : null,
            'height' => $this->height ? (float) $this->height : null,
            'width' => $this->width ? (float) $this->width : null,
            'length' => $this->length ? (float) $this->length : null,
            'status' => $this->status,
            'is_featured' => (bool) $this->is_featured,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'category' => new CategoryResource($this->whenLoaded('category')),
        ];
    }
}
