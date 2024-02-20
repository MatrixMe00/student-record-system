<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $role_id = request()->user()->role_id;
        $authorize = $role_id <= 3 || $role_id == 5;
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
            "lname" => ["required", "string", "max:255"],
            "oname" => ["required", "string", "max:255"],
            "next_of_kin" => ["sometimes", "required", "string", "max:255"],
            "primary_phone" => ["required", "max:13", "min:10"],
            "secondary_phone" => ["sometimes", "nullable", "max:13", "min:10"],
            "school_id" => ["sometimes", "required", "integer", Rule::exists("schools", 'id')],
            "program_id" => ["sometimes", "required", "integer", Rule::exists("programs", 'id')]
        ];
    }
}
