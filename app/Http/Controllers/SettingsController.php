<?php

namespace App\Http\Controllers;

use App\Constants\LogType;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\Settings;
use App\Http\Requests\StoreSettingsRequest;
use App\Http\Requests\UpdateSettingsRequest;
use App\Models\ActivityLog;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSettingsRequest $request)
    {
        $validated = $request->validated();
        $settings = Settings::create($validated);

        ActivityLog::dev_success_log(LogType::SYSTEM_INFO, "new system settings created", $settings);

        // enable or disable the price value
        AuthenticatedSessionController::payment_ready();

        return redirect()->back()->with(["success" => true, "message" => "System setting '$settings->visual_name' created"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Settings $settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Settings $settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettingsRequest $request, $key)
    {
        $settings = Settings::where("name", $key);

        if($settings->exists()){
            $settings = $settings->first();
            $original = $settings;
            $validated = $request->validated();
            $settings->update($validated);

            ActivityLog::dev_success_log(LogType::SYSTEM_INFO, "system setting '". chars_format($settings->name) ."' updated", ["current" => $settings, "original" => $original]);

            // enable or disable the price value
            AuthenticatedSessionController::payment_ready();
        }else{
            abort(404);
        }

        return back()->with(["success" => true, "message" => "System settings have been updated"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Settings $settings)
    {
        $settings->delete();
    }
}
