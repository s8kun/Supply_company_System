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
}
