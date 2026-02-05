<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'costPrice' => 'sometimes|numeric|min:0',
            'sellPrice' => 'sometimes|numeric|min:0|gte:costPrice',
            'currentQuantity' => 'sometimes|integer|min:0',
            'reorderLevel' => 'sometimes|integer|min:1',
            'reorderQuantity' => 'sometimes|integer|min:1|gte:reorderLevel',
            'images' => 'nullable|array|min:3|max:4',
            'images.*' => 'image|max:2048',
        ];
    }
}
