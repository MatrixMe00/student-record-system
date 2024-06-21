<?php

namespace App\Models;

use App\Traits\UserModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    use HasFactory, UserModelTrait;
    protected $table = "activitylogs";

    protected $guarded = [];

    // many activity logs belong to one user
    public function user() :BelongsTo{
        return $this->belongsTo(User::class);
    }

    // get the specified model of this user
    public function user_model() :Model{
        return $this->user_model($this->user);
    }

    // creating a user log
    public static function add_log(string $activity_type, string $message = "", bool $add_admin = false, int $admin_level = 2, ?array $log_details = null){
        if(empty($message)){
            $message = self::common_activites($activity_type);
        }

        if($log_details){
            $log_details = encode_array($log_details);
        }

        self::create([
            "activity_type" => $activity_type, "message" => $message,
            "user_id" => Auth::user()->id, "school_id" => session('school_id') ?? null,
            "admin_level" => $admin_level, "add_admin" => $add_admin, "log_details" => $log_details
        ]);
    }

    // common activity types
    private static function common_activities(string $activity_type){
        $message = "";

        switch($activity_type){
            case "login": $message = "Account login was successful"; break;
            case "logout": $message = "You logged out of your account"; break;
            case "account-update": $message = "You made an update to your account profile"; break;
            case "school-update": $message = "Changes were made to your school account profile"; break;
            case "school-add": $message = "Created your school account"; break;
        }

        return $message;
    }

    /**
     * Changes an activity type into a readable format
     * @param string $activity_type The activity type
     * @return string
     */
    public static function readable_activity(string $activity_type):string{
        return ucwords(str_replace("-"," ",$activity_type));
    }
}
