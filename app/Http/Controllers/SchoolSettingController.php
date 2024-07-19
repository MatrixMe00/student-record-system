<?php

namespace App\Http\Controllers;

use App\Constants\LogType;
use App\Models\ActivityLog;
use App\Models\SchoolSetting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SchoolSettingController extends Controller
{
    /**
     * @var bool $message_only Used for store and update to tell that it should only show message and not redirect
     */
    private bool $message_only = false;

    public function store(Request $request)
    {
        $validated = $request->validate([
            "school_id" => ["required", "integer", Rule::exists("schools", "id")],
            "settings_name" => ["required", "string"],
            "value" => ["required", "string"]
        ]);

        $settings = SchoolSetting::create($validated);
        ActivityLog::dev_success_log(LogType::SYSTEM_INFO, "{school->name} has added a new system settings for {settings_name}", $settings);

        $message = chars_format($settings->settings_name)." data has been added successfully";

        if($this->message_only){
            return $message;
        }else{
            return redirect()->back()->with(["success" => true, "message" => $message]);
        }
    }

    /**
     * Checks if a system setting already exists which is then passed into
     * @param string $settings_name The name of the settings
     * @param mixed $object Takes the address of an object. Null on default
     * @return bool
     */
    private function check_setting(string $settings_name, &$object = null){
        $object = SchoolSetting::where("settings_name", $settings_name);
        return $object->exists();
    }

    /**
     * This is used to either tell the system to store or update a settings information
     * @param Request $request Takes the request data
     */
    public function save_update(Request $request){
        $this->message_only = true;

        if(is_array($request->settings_name)){
            foreach($request->settings_name as $key => $settings_name){
                $this->process_request($settings_name, $key);
            }

            $message = count($request->settings_name)." settings updated";
        }else{
            $message = $this->process_request($request);
        }

        return redirect()->back()->with(["success" => true, "message" => $message]);
    }

    /**
     * This function processes the request sent
     * @param Request|string $request_setting The request or settings
     * @param ?int $key The desired resource to pick from the request
     */
    private function process_request(Request|string $request_setting, ?int $key = null){
        // save or update based on settings existence
        if($request_setting instanceof Request){
            $setting = $request_setting->settings_name;
        }else{
            $setting = $request_setting;
        }

        if(!is_null($key) && is_integer($key)){
            $request_setting = make_request(request(), $key);
        }

        if($this->check_setting($setting, $setting_object)){
            $message = $this->update($request_setting, $setting_object->first());
        }else{
            $message = $this->store($request_setting);
        }

        return $message;
    }

    public function update(Request $request, SchoolSetting $school_setting)
    {
        $original = $school_setting;
        $validated = $request->validate([
            "value" => ["required", "string"]
        ]);

        $school_setting->update($validated);

        if(model_changed($school_setting))
            ActivityLog::dev_success_log(LogType::SYSTEM_INFO, "{school->name} changed the settings for {settings_name}", ["original" => $original, "current" => $school_setting]);

        $message = chars_format($school_setting->settings_name." has been updated");

        if($this->message_only){
            return $message;
        }else{
            return redirect()->back()->with(["success" => true, "message" => $message]);
        }
    }


    public function destroy(SchoolSetting $schoolSetting)
    {
        $schoolSetting->delete();
    }
}
