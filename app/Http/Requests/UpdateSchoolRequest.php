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
            "id" => ["required", "integer", Rule::exists("schools", "id")],
            "school_name" => ["required", "string"],
            "school_slug" => ["required", "string"],
            "circuit" => ["required", 'string'],
            "district" => ["nullable", "required", "string"],
            "logo_path" => ["sometimes", "string", "nullable"],
            "gps_address" => ["required", "string", "max:15"],
            "box_number" => ["required", "string"],
            "school_type" => ["required", "string", Rule::in(["public", "private"])],
            "school_head" => ["required", "string"],
            "description" => ["required", "string"],
            "school_email" => ["required", "string", "email"],
            "admin_id" => ["required", "integer", Rule::exists("admins", "user_id")]
        ];
    }
}
