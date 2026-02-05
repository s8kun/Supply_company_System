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
}
