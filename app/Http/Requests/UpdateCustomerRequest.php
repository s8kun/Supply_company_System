<?php

namespace App\Http\Requests;

use App\Traits\CamelCaseRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
     * Validation rules for updating a customer.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstName' => 'sometimes|required|string|max:255',
            'middleName' => 'sometimes|required|string|max:255',
            'lastName' => 'sometimes|required|string|max:255',
            'houseNo' => 'sometimes|required|string|max:50',
            'streetName' => 'sometimes|required|string|max:255',
            'city' => 'sometimes|required|string|max:100',
            'zipCode' => 'sometimes|required|string|max:20',
            'phone' => 'sometimes|required|string|max:20|unique:customers,phone,' . $this->customer->customer_id . ',customer_id',
            'creditLimit' => 'sometimes|required|numeric|min:0',
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
            'houseNo.required' => 'حقل رقم المنزل مطلوب.',
            'streetName.required' => 'حقل اسم الشارع مطلوب.',
            'city.required' => 'حقل المدينة مطلوب.',
            'zipCode.required' => 'حقل الرمز البريدي مطلوب.',
            'phone.required' => 'حقل رقم الهاتف مطلوب.',
            'phone.unique' => 'حقل رقم الهاتف مستخدم مسبقا.',
            'creditLimit.required' => 'حقل الحد الائتماني مطلوب.',
        ];
    }
}
