<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Traits\CamelCaseRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    use CamelCaseRequestTrait;

    /**
     * Force customer_id to the authenticated customer's record.
     */
    protected function prepareForValidation(): void
    {
        $user = $this->user();

        if (!$user || $user->role !== User::ROLE_CUSTOMER) {
            return;
        }

        if ($user->customer) {
            $this->merge(['customerId' => $user->customer->customer_id]);
        }
    }

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
            'customerId' => 'required|exists:customers,customer_id',
            'dueDate' => 'required|date|after_or_equal:today',
            'items' => 'required|array|min:1',
            'items.*.productId' => 'required|distinct|exists:products,product_id',
            'items.*.quantity' => 'required|integer|min:1',
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
            'customerId.required' => 'حقل رقم العميل مطلوب.',
            'customerId.exists' => 'رقم العميل غير موجود.',
            'dueDate.required' => 'حقل تاريخ الاستحقاق مطلوب.',
            'items.required' => 'حقل العناصر مطلوب.',
            'items.*.productId.required' => 'حقل المنتج مطلوب.',
            'items.*.productId.exists' => 'المنتج غير موجود.',
            'items.*.quantity.required' => 'حقل الكمية مطلوب.',
        ];
    }
}
