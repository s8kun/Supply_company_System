<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for creating a product.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:products,name',
            'description' => 'required',
            'costPrice' => 'required|numeric|min:0',
            'sellPrice' => 'required|numeric|gte:costPrice',
            'currentQuantity' => 'required|integer|min:0',
            'reorderLevel' => 'required|integer|min:1',
            'reorderQuantity' => 'required|integer|gte:reorderLevel',
            'images' => 'nullable|array|min:3|max:4',
            'images.*' => 'image|max:2048',
        ];
    }
}
