<?php

namespace App\Http\Requests;

use App\Enums\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateOrderRequest extends FormRequest
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
            'customerID' => 'sometimes|required|exists:customers,customerID',
            'totalPrice' => 'sometimes|required|numeric|min:0',
            'dueDate' => 'sometimes|required|date|after_or_equal:today',
            'orderStatus' => ['sometimes', 'required', new Enum(OrderStatus::class)],
            'isPaid' => 'sometimes|required|boolean',
        ];
    }
}
