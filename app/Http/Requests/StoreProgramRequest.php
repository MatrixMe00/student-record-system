<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProgramRequest extends FormRequest
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
            "name" => ["required","string"],
            "slug" => ["sometimes", "nullable", "string"],
            "school_id" => ["required", "integer", Rule::exists("schools")],
            "class_teacher" => ["required", "integer", Rule::exists("teachers", "user_id")]
        ];
    }
}