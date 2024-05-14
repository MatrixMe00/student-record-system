<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreStudentBillRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $authorize = Auth::user()->role_id == 3;
        return $authorize;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "school_id" => ["required", "integer", Rule::exists("schools", "id")],
            "program_id" => ["required", "integer", Rule::exists("programs", "id")],
            "student_id.*" => ["required", "integer", Rule::exists("students", "user_id")],
            "amount.*" => ["required", "numeric", "min:0", "decimal:0,2"]
        ];
    }
}
