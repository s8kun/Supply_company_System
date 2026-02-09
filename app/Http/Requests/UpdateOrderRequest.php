<?php

namespace App\Http\Requests;

use App\Traits\CamelCaseRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    use CamelCaseRequestTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for updating an order.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'dueDate' => 'sometimes|required|date|after_or_equal:today',
            'isPaid' => 'sometimes|required|boolean',
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'dueDate.required' => 'حقل تاريخ الاستحقاق مطلوب.',
            'isPaid.required' => 'حقل حالة الدفع مطلوب.',
        ];
    }
}
