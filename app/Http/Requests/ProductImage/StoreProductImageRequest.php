<?php

namespace App\Http\Requests\ProductImage;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'alt_text' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_primary' => 'nullable|boolean',
        ];
    }
}
