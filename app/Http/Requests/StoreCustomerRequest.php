<?php

namespace App\Http\Requests;

use App\Traits\CamelCaseRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
     * Validation rules for creating a customer.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstName' => 'required',
            'middleName' => 'required',
            'lastName' => 'required',
            'phone' => 'required|unique:customers,phone',
            'houseNo' => 'required',
            'streetName' => 'required',
            'city' => 'required',
            'zipCode' => 'required',
            'creditLimit' => 'required|numeric|min:0',
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
            'firstName.required' => 'حقل الاسم الاول مطلوب.',
            'middleName.required' => 'حقل الاسم الاوسط مطلوب.',
            'lastName.required' => 'حقل الاسم الاخير مطلوب.',
            'phone.required' => 'حقل رقم الهاتف مطلوب.',
            'phone.unique' => 'حقل رقم الهاتف مستخدم مسبقا.',
            'houseNo.required' => 'حقل رقم المنزل مطلوب.',
            'streetName.required' => 'حقل اسم الشارع مطلوب.',
            'city.required' => 'حقل المدينة مطلوب.',
            'zipCode.required' => 'حقل الرمز البريدي مطلوب.',
            'creditLimit.required' => 'حقل الحد الائتماني مطلوب.',
        ];
    }
}
