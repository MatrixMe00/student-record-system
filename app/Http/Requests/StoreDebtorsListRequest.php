<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreDebtorsListRequest extends FormRequest
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
            "school_id" => ["required", "integer", Rule::exists("schools", "id")],
            "id.*" => ["sometimes", "integer"],
            "student_id.*" => ["required", "integer", Rule::exists("students", "user_id"), Rule::unique("debtors_lists","student_id")],
            "amount.*" => ["required", "numeric", "min:1", "decimal:0,2"],
            "status.*" => ["sometimes", "boolean"]
        ];
    }
}
