<?php

namespace App\Http\Requests;

use App\Enums\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customerID' => 'required|exists:customers,customerID',
            'totalPrice' => 'required|numeric|min:0',
            'dueDate' => 'required|date|after_or_equal:today',
            'orderStatus' => ['required', new Enum(OrderStatus::class)],
            'isPaid' => 'required|boolean',
        ];
    }
}
