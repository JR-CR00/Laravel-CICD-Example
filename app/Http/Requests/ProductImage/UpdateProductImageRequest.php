<?php

namespace App\Http\Requests\ProductImage;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductImageRequest extends FormRequest
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
            'alt_text' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_primary' => 'nullable|boolean',
        ];
    }
}
