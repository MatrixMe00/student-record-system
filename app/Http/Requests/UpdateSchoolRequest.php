<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSchoolRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            "id" => ["required", "integer", Rule::exists("schools")],
            "school_name" => ["required", "string", Rule::unique("schools", "name")],
            "school_slug" => ["required", "string"],
            "logo_path" => ["sometimes", "string", "nullable"],
            "gps_address" => ["required", "string", "max:15"],
            "box_number" => ["required", "string", Rule::unique("schools", "box_number")],
            "description" => ["required", "string"],
            "school_email" => ["required", "string"],
            "admin_id" => ["required", "integer", Rule::exists("admins", "user_id")]
        ];
    }
}
