<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Traits\CamelCaseRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class RedeemCodeRequest extends FormRequest
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
     * Validation rules for redeeming a code.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customerId' => 'required|exists:customers,customer_id',
            'code' => 'required|string',
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
            'code.required' => 'حقل الكود مطلوب.',
        ];
    }
}
