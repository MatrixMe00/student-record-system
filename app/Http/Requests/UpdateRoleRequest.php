<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $authorize = request()->user()->role_id <= 3;
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
            "id" => ["required", "integer"],
            "name" => ["required", "string", Rule::unique("roles", "name")],
            "access_value" => ["sometimes", "integer"],
            "school_id" => ["sometimes", "integer", Rule::exists("schools", "id")]
        ];
    }
}
