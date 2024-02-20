<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeacherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $authorized = request()->user()->user_role < 5;
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
            "lname" => ["string", "required", "max:255"],
            "oname" => ["string", "required", "max:255"],
            "primary_phone" => ["string", "required", "min:10", "max:13"],
            "secondary_phone" => ["sometimes", "nullable", "string", "min:10", "max:13"],
            "class_teacher" => ["sometimes", "boolean"],
            "program_id" => ["sometimes", "integer", "nullable", Rule::exists("programs", "id")]
        ];
    }
}
