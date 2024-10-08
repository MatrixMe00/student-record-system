<?php

namespace App\Http\Requests;

use App\Models\Settings;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSettingsRequest extends FormRequest
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
            "visual_name" => ["required", "string"],
            "default_value" => ["nullable", "sometimes", "string"],
            "role_access" => ["required", "string"],
            "input_type" => ["sometimes", "required", "string"],
            "placeholder" => ["sometimes", "nullable", "string"],
            "options" => ["sometimes", "nullable", "string"]
        ];
    }
}
