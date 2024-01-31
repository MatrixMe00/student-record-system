<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTeacherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $authorized = request()->user()->user_role < 5;
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
            "user_id" => ["integer", "required", Rule::exists("users", "id")],
            "lname" => ["string", "required", "max:255"],
            "oname" => ["string", "required", "max:255"],
            "phone_number" => ["string", "required", "min:10", "max:13"],
            "secondary_number" => ["string", "sometimes", "min:10", "max:13"],
            "class_teacher" => ["boolean", "sometimes"],
            "program_id" => ["integer", "nullable", "sometimes", Rule::exists("programs", "id")]
        ];
    }
}
