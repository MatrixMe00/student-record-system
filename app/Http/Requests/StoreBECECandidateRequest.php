<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreBECECandidateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $authorized = Auth::user()->role_id == 3;
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
            "student_id" => ["required", "integer", "min:1", Rule::exists("students", "user_id")],
            "school_id" => ["required", "integer", "min:1", Rule::exists("schools", "id")],
            "index_number" => ["sometimes", "required", "numeric"],
            "student_token" => ["required", "string", Rule::unique("bece_candidates", "student_token")],
            "placement" => ["sometimes", "nullable", "string"],
            "academic_year" => ["required", "string"]
        ];
    }
}
