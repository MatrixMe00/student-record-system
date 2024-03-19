<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSchoolRequest extends FormRequest
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
            "school_name" => ["required", "string", Rule::unique("schools", "school_name")],
            "school_slug" => ["required", "string"],
            "logo_path" => ["nullable", "required", "file"],
            "location" => ["required", 'string'],
            "gps_address" => ["required", "string", "max:15", Rule::unique("schools", "gps_address")],
            "box_number" => ["required", "string", Rule::unique("schools", "box_number")],
            "school_type" => ["required", "string", Rule::in(["public", "private"])],
            "school_head" => ["required", "string"],
            "description" => ["required", "string"],
            "school_email" => ["required", "string", "email", Rule::unique("schools", "school_email")],
            "admin_id" => ["required", "integer", Rule::exists("admins", "user_id")]
        ];
    }
}
