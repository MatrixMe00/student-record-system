<?php

namespace App\Http\Requests;

use App\Models\Program;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRemarksRequest extends FormRequest
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
            "teacher_id" => ["required", "integer", "exists:".Teacher::class],
            "program_id" => ["required", "integer", "exists:".Program::class],
            "semester" => ["required", "integer", "min:1", "max:3"],
            "status" => ["sometimes", "required", "string", "in:pending,accepted,rejected"],
            "student_id.*" => ["required", "integer", "exists:".Student::class],
            "total_marks.*" => ["required", "integer", "min:0"],
            "position.*" => ["required", "integer", "min:1"],
            "remark.*" => ["required", "string"]
        ];
    }
}
