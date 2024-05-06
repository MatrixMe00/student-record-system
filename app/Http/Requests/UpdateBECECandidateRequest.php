<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateBECECandidateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $authorized = Auth::user()->role_id <= 3;
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
            "index_number" => ["sometimes", "nullable", "required", "numeric"],
            "bece_result" => ["sometimes", "nullable", "required", "file"],
            "placement_school" => ["sometimes", "nullable", "required", "file"],
            "result_checker" => ["sometimes", "nullable", "string"],
            "placement_checker" => ["sometimes", "nullable", "string"]
        ];
    }
}
