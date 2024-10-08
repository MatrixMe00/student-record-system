<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreotherRequest extends FormRequest
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
            "user_id" => ["required", Rule::exists("users", "id"), "integer"],
            "lname" => ["required", "string", "max:255"],
            "oname" => ["required", "string", "max:255"],
            "primary_phone" => ["required", "max:13", "min:10"],
            "secondary_phone" => ["sometimes", "nullable", "max:13", "min:10"],
            "school_id" => ["nullable", "integer", Rule::exists("schools", "id")]
        ];
    }
}
