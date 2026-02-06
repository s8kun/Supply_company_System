<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Force customerID to the authenticated customer's record.
     */
    protected function prepareForValidation(): void
    {
        $user = $this->user();

        if (!$user || $user->role !== User::ROLE_CUSTOMER) {
            return;
        }

        if ($user->customer) {
            $this->merge(['customerID' => $user->customer->customerID]);
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
            'customerID' => 'required|exists:customers,customerID',
            'dueDate' => 'required|date|after_or_equal:today',
            'items' => 'required|array|min:1',
            'items.*.productID' => 'required|distinct|exists:products,productID',
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
            'customerID.required' => 'حقل رقم العميل مطلوب.',
            'customerID.exists' => 'رقم العميل غير موجود.',
            'dueDate.required' => 'حقل تاريخ الاستحقاق مطلوب.',
            'items.required' => 'حقل العناصر مطلوب.',
            'items.*.productID.required' => 'حقل المنتج مطلوب.',
            'items.*.productID.exists' => 'المنتج غير موجود.',
            'items.*.quantity.required' => 'حقل الكمية مطلوب.',
        ];
    }
}
