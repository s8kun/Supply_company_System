<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for placing a new order.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customerID' => 'required|exists:customers,customerID',
            'dueDate' => 'required|date|after_or_equal:today',
            'items' => 'required|array|min:1',
            'items.*.productID' => 'required|distinct|exists:products,productID',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }
}
