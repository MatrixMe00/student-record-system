<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ActivityLogController extends Controller
{
    public function create()
    {
        # code...
    }

    public function show(Request $request, ActivityLog $activityLog)
    {
        return $activityLog;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "activity_type" => ["string", "required"],
            "message" => ["string", "required"],
            "user_id" => ["integer", "required", Rule::exists("users", "id")]
        ]);

        $log = ActivityLog::create($validated);

        return $log;
    }

    public function update(Request $request, ActivityLog $activityLog)
    {
        $validated = $request->validate([
            "activity_type" => ["string", "required"],
            "message" => ["string", "required"],
            "user_id" => ["integer", "required", Rule::exists("users", "id")]
        ]);

        $activityLog->update($validated);
    }

    public function destroy(Request $request, ActivityLog $activityLog)
    {
        $activityLog->delete();

        return request()->noContent();
    }
}
