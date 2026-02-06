<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for creating a customer.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|unique:customers,phone',
            'house_no' => 'required',
            'street_name' => 'required',
            'city' => 'required',
            'zip_code' => 'required',
            'credit_limit' => 'required|numeric|min:0',
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
            'phone.required' => 'حقل رقم الهاتف مطلوب.',
            'phone.unique' => 'حقل رقم الهاتف مستخدم مسبقا.',
            'house_no.required' => 'حقل رقم المنزل مطلوب.',
            'street_name.required' => 'حقل اسم الشارع مطلوب.',
            'city.required' => 'حقل المدينة مطلوب.',
            'zip_code.required' => 'حقل الرمز البريدي مطلوب.',
            'credit_limit.required' => 'حقل الحد الائتماني مطلوب.',
        ];
    }
}
