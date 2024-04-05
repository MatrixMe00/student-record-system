<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTeacherRemarksRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $authorized = auth()->user()->role_id <= 4 ? true : false;
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
            "remark_token" => ["required", "string"],
            "school_id" => ["required", "integer", Rule::exists("schools", "id")],
            "teacher_id" => ["required", "integer", Rule::exists("teachers", "user_id")],
            "program_id" => ["required", "integer", Rule::exists("programs", "id")],
            "semester" => ["required", "integer", "min:1", "max:3"],
            "status" => ["sometimes", "required", "string", "in:pending,accepted,rejected"],
            "student_id.*" => ["required", "integer", Rule::exists("students", "user_id")],
            "total_marks.*" => ["required", "integer", "min:0"],
            "attendance.*" => ["required", "integer", "min:0", "max: 80"],
            "position.*" => ["required", "integer", "min:1"],
            "remark.*" => ["required", "string"],
            "h_remark.*" => ["sometimes", "required", "string"],
            "interest.*" => ["sometimes", "required", "string"],
            "conduct.*" => ["sometimes", "required", "string"],
            "attitude.*" => ["sometimes", "required", "string"],
            "promoted.*" => ["sometimes", "integer", "min:-1", "max:1"]
        ];
    }
}
