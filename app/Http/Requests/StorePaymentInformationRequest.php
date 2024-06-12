<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StorePaymentInformationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $authorized = Auth::user()->role_id <= 3;
        return $authorized;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "user_id" => ["required", "integer", Rule::exists("users", "id")],
            "bank_code" => ["required", "string", Rule::exists("paystack_banks", "code")],
            "account_number" => ["required", "string", Rule::unique("payment_information", "account_number")],
            "type" => ["required", "string"],
            "master" => ["boolean"]
        ];
    }
}
