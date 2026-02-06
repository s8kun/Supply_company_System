<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for updating a customer.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'sometimes|required|string|max:255',
            'middle_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'house_no' => 'sometimes|required|string|max:50',
            'street_name' => 'sometimes|required|string|max:255',
            'city' => 'sometimes|required|string|max:100',
            'zip_code' => 'sometimes|required|string|max:20',
            'phone' => 'sometimes|required|string|max:20|unique:customers,phone,' . $this->customer->customerID . ',customerID',
            'credit_limit' => 'sometimes|required|numeric|min:0',
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
            'first_name.required' => 'حقل الاسم الاول مطلوب.',
            'middle_name.required' => 'حقل الاسم الاوسط مطلوب.',
            'last_name.required' => 'حقل الاسم الاخير مطلوب.',
            'house_no.required' => 'حقل رقم المنزل مطلوب.',
            'street_name.required' => 'حقل اسم الشارع مطلوب.',
            'city.required' => 'حقل المدينة مطلوب.',
            'zip_code.required' => 'حقل الرمز البريدي مطلوب.',
            'phone.required' => 'حقل رقم الهاتف مطلوب.',
            'phone.unique' => 'حقل رقم الهاتف مستخدم مسبقا.',
            'credit_limit.required' => 'حقل الحد الائتماني مطلوب.',
        ];
    }
}
