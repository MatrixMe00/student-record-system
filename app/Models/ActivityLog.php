<?php

namespace App\Models;

use App\Traits\UserModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    use HasFactory;
    protected $table = "activitylogs";

    protected $guarded = [];
    const UPDATED_AT = null;

    /**
     * System user ID - the first user created (developer role)
     * Used for system logs when no user is authenticated
     */
    const SYSTEM_USER_ID = 1;

    /**
     * @var ?int $user_id A selected user id other than the authenticated user id
     */
    public static ?int $user_id = null;

    /**
     * @var bool $initialized Used to initialize the class
     */
    private static bool $initialized = false;

    // many activity logs belong to one user
    public function user() :BelongsTo{
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        // Call the initialization method
        self::initialize();
    }

    private static function initialize(){
        parent::boot();

        if(!static::$initialized){
            static::$initialized = true;
        }
    }

    // Override the default newQuery method to add constraints
    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery($excludeDeleted);
        $table = self::getTable();

        // based on the user role
        $school_id = session('school_id') ?? null;
        if($school_id){
            $query->where($table.'.school_id', $school_id);
        }

        return $query;
    }

    /**
     * Gets the logs of a specified user
     *
     * If user id is not defined, the authenticated user is used
     * @param ?int $user_id The user id
     * @param int $limit The number of results to provide. Provides 10 by default
     * @param ?int $start Usually for pagination to show where to start from
     * @param bool $desc Return results in descending order
     */
    public static function get_logs_query(?int $user_id = null, int $limit = 10, ?int $start = null, bool $desc = true){
        // Use the authenticated user's ID if no user ID is provided
        if (is_null($user_id)) {
            $user_id = auth()->id();
        }

        // Initialize the query
        $query = ActivityLog::query();

        // Add user ID condition if it's specified
        // Note: user_id = 1 is the system user for system logs
        if (!empty($user_id)) {
            $query->where('user_id', $user_id);
        }

        // Add order by clause to sort by creation date in descending order
        if($desc){
            $query->orderBy('created_at', 'desc');
        }

        // Apply limit and offset for pagination if provided
        if (!is_null($start)) {
            $query->offset($start);
        }

        if (!is_null($limit)) {
            $query->limit($limit);
        }

        // Execute the query and get the results
        return $query;
    }

    /**
     * Gets the logs of a specified user
     *
     * If user id is not defined, the authenticated user is used
     * @param ?int $user_id The user id
     * @param int $limit The number of results to provide. Provides 10 by default
     * @param ?int $start Usually for pagination to show where to start from
     * @param bool $desc Return results in descending order
     */
    public static function get_logs(?int $user_id = null, int $limit = 10, ?int $start = null, bool $desc = true){
        return self::get_logs_query($user_id, $limit, $start, $desc)->get();
    }

    // creating a user log
    private static function add_log(string $activity_type, string $message = "", bool $add_admin = false, $is_error = false, int $admin_level = 3, array|Model|null $log_details = null){
        $message = $message == "" ? static::common_activities($activity_type) : $message;

        if($log_details){
            if(!is_array($log_details)){
                $log_details = self::model_to_array($log_details);
            }else{
                $log_details = self::modify_array($log_details);
            }
            $log_details = encode_array($log_details);
        }

        // set as a system error if there is no user activity involved
        // Use system user ID instead of 0 for system logs
        if(is_null(self::$user_id) && !Auth::check()){
            self::$user_id = self::SYSTEM_USER_ID; // System user (developer role)
        }

        ActivityLog::create([
            "activity_type" => $activity_type, "message" => $message,
            "user_id" => self::$user_id ?? Auth::user()->id, "school_id" => session('school_id') ?? null,
            "admin_level" => $admin_level, "add_admin" => $add_admin, "log_details" => $log_details,
            "is_error" => $is_error, "ip_address" => request()->ip(), "user_agent" => request()->userAgent()
        ]);
    }

    /**
     * Default success logs could be handled with this
     * @param string $activity_type The activity type
     * @param string $message The message to be logged
     * @param array|Model|null $log_details Other details to be logged
     */
    public static function success_log(string $activity_type, string $message = "", array|Model|null $log_details = null){
        self::add_log($activity_type, $message, log_details: $log_details);
    }

    /**
     * This modifies a log element into all arrays
     *
     * This will automatically make an array of the contents of an array
     * @param array $log_details The log details to be transformed
     * @return array
     */
    private static function modify_array(array $log_details){
        $keys = array_keys($log_details);
        $values = array_values($log_details);
        $log_details = [];

        foreach($values as $key_count => $value){
            if($value instanceof Model || is_array($value))
                $log_details[$keys[$key_count]] = self::transform_element($value);
        }

        return $log_details;
    }

    /**
     * Converts a model or array into an array
     *
     * @param array|Model|null $element The element to be transformed
     * @return ?array
     */
    private static function transform_element(array|Model|null $element) :?array{
        // return null if element is null
        if(is_null($element)){
            return null;
        }

        // change model to array
        if(!is_array($element)){
            return self::model_to_array($element);
        }

        // no change
        return $element;
    }

    /**
     * Default error logs could be handled with this
     * @param string $activity_type The activity type
     * @param string $message The message to be logged
     * @param array|Model|null $log_details Other details to be logged
     */
    public static function error_log(string $activity_type, string $message = "", array|Model|null $log_details = null){
        self::add_log($activity_type, $message, is_error: true, log_details: $log_details);
    }

    /**
     * Success logs which includes superadmin access
     * @param string $activity_type The activity type
     * @param string $message The message to be logged
     * @param array|Model|null $log_details Other details to be logged
     */
    public static function super_success_log(string $activity_type, string $message = "", array|Model|null $log_details = null){
        self::add_log($activity_type, $message, true, log_details: $log_details);
    }

    /**
     * Error logs which includes superadmin access
     * @param string $activity_type The activity type
     * @param string $message The message to be logged
     * @param array|Model|null $log_details Other details to be logged
     */
    public static function super_error_log(string $activity_type, string $message = "", array|Model|null $log_details = null){
        self::add_log($activity_type, $message, true, is_error: true, log_details: $log_details);
    }

    /**
     * Success logs which seen only by dev users
     * @param string $activity_type The activity type
     * @param string $message The message to be logged
     * @param array|Model|null $log_details Other details to be logged
     */
    public static function dev_success_log(string $activity_type, string $message = "", array|Model|null $log_details = null){
        self::add_log($activity_type, $message, add_admin: true, admin_level: 1, log_details: $log_details);
    }

    /**
     * Error logs which seen only by dev users
     * @param string $activity_type The activity type
     * @param string $message The message to be logged
     * @param array|Model|null $log_details Other details to be logged
     */
    public static function dev_error_log(string $activity_type, string $message = "", array|Model|null $log_details = null){
        self::add_log($activity_type, $message, add_admin: true, admin_level: 1, is_error:true, log_details: $log_details);
    }

    // common activity types
    private static function common_activities(string $activity_type){
        $message = "";

        switch($activity_type){
            case "login": $message = "account login was successful"; break;
            case "logout": $message = "closed account session"; break;
            case "account-update": $message = "updated account profile data"; break;
            case "school-update": $message = "updated school account profile"; break;
            case "school-add": $message = "created your school account"; break;
            case "password-update": $message = "account password has been changed"; break;
            case "email-verify": $message = "email verification was successful"; break;
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

    /**
     * This sets the model into an array format
     * @param Model $model The model to be stored
     * @return array
     */
    private static function model_to_array(Model $model) :array{
        $array = $model->toArray();
        $array["model_class"] = class_basename($model);

        return $array;
    }

    /**
     * This is used to change an array into a model
     * @param array $array The array
     * @return ?Model
     */
    public static function array_to_model(?array $array) :?Model{
        if(!isset($array["model_class"])){
            return null;
        }
        $model = "\App\Models\\".$array["model_class"];

        // remove the class name
        unset($array["model_class"]);

        $model = new $model($array);

        return $model;
    }

    /**
     * The school this belongs to
     */
    public function school() :BelongsTo{
        return $this->belongsTo(School::class);
    }

    /**
     * unserialize the log_details before sent to frontend
     */
    public function getLogDetailsAttribute(){
        return decode_array($this->attributes["log_details"]);
    }
}
