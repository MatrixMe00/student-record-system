<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $authorized = request()->user()->role_id <= 4;
        return true;
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
            "lname" => ["required", "string", "max:255"],
            "oname" => ["required", "string", "max:255"],
            "next_of_kin" => ["required", "string", "max:255"],
            "primary_phone" => ["required", "digits_between:10,13"],
            "secondary_phone" => ["sometimes", "nullable", "digits_between:10,13"],
            "school_id" => ["required", "integer", Rule::exists("schools", 'id')],
            "program_id" => ["required", "integer", Rule::exists("programs", 'id')]
        ];
    }
}
