<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use SoftDeletes;

    const UPDATED_AT = null;

    protected $fillable = [
        'product_id',
        'image_url',
        'alt_text',
        'sort_order',
        'is_primary',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
