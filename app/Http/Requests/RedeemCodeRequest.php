<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RedeemCodeRequest extends FormRequest
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
     * Validation rules for redeeming a code.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customerID' => 'required|exists:customers,customerID',
            'code' => 'required|string',
        ];
    }
}
