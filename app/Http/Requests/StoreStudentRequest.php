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
            "lname" => ["required", "max:255"],
            "oname" => ["required", "max:255"],
            "next_of_kin" => ["required", "max:255"],
            "primary_phone" => ["required", "max:13", "min:10"],
            "secondary_phone" => ["sometimes", "max:13", "min:10"],
            "school_id" => ["required", "integer", Rule::exists("schools", 'id')],
            "program_id" => ["required", "integer", Rule::exists("programs", 'id')]
        ];
    }
}
