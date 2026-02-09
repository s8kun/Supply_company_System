<?php

namespace App\Http\Requests;

use App\Enums\DeliveryStatus;
use App\Traits\CamelCaseRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateOrderItemRequest extends FormRequest
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
     * Validation rules for updating delivery status.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'deliveryStatus' => ['required', new Enum(DeliveryStatus::class)],
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
            'deliveryStatus.required' => 'حقل حالة التوصيل مطلوب.',
        ];
    }
}
