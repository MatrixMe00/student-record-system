<?php

namespace App\Http\Controllers;

use App\Models\SchoolSetting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SchoolSettingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            "school_id" => ["required", "integer", Rule::exists("schools")],
            "settings" => ["required", "string"],
            "admin_id" => ["required", "integer", Rule::exists("admins","user_id")]
        ]);

        SchoolSetting::create($validated);
    }

    public function update(Request $request, SchoolSetting $schoolSetting)
    {
        $validated = $request->validate([
            "school_id" => ["required", "integer", Rule::exists("schools")],
            "settings" => ["required", "string"],
            "admin_id" => ["required", "integer", Rule::exists("admins","user_id")]
        ]);

        $schoolSetting->update($validated);
    }

    public function destroy(SchoolSetting $schoolSetting)
    {
        $schoolSetting->delete();
    }
}
