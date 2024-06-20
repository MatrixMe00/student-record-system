<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->role_id <= 3;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "user_id" => ["sometimes", "required", Rule::exists("users", "id"), "integer"],
            "lname" => ["required", "max:255"],
            "oname" => ["required", "max:255"],
            "primary_phone" => ["required", "max:13", "min:10"],
            "secondary_phone" => ["sometimes", "nullable", "digits_between:10,13"],
            "school_id" => ["nullable", "integer", Rule::requiredIf(function(){
                return Auth::check() && Auth::user()->role_id == 3;
            }), Rule::exists("schools", "id")]
        ];
    }
}
