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
    const UPDATED_AT = null;
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

    // get the specified model of this user
    public function user_model() :Model{
        return $this->user_model($this->user);
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

        // Add user ID condition if it's specified [empty means system call]
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
    private static function add_log(string $activity_type, string $message = "", bool $add_admin = false, $is_error = false, int $admin_level = 3, ?array $log_details = null){
        $message = $message == "" ? static::common_activities($activity_type) : $message;

        if($log_details){
            $log_details = encode_array($log_details);
        }

        ActivityLog::create([
            "activity_type" => $activity_type, "message" => $message,
            "user_id" => Auth::user()->id, "school_id" => session('school_id') ?? null,
            "admin_level" => $admin_level, "add_admin" => $add_admin, "log_details" => $log_details,
            "is_error" => $is_error, "ip_address" => request()->ip(), "user_agent" => request()->userAgent()
        ]);
    }

    /**
     * Default success logs could be handled with this
     * @param string $activity_type The activity type
     * @param string $message The message to be logged
     * @param ?array $log_details Other details to be logged
     */
    public static function success_log(string $activity_type, string $message = "", ?array $log_details = null){
        self::add_log($activity_type, $message, log_details: $log_details);
    }

    /**
     * Default error logs could be handled with this
     * @param string $activity_type The activity type
     * @param string $message The message to be logged
     * @param ?array $log_details Other details to be logged
     */
    public static function error_log(string $activity_type, string $message = "", ?array $log_details = null){
        self::add_log($activity_type, $message, is_error: true, log_details: $log_details);
    }

    /**
     * Success logs which includes superadmin access
     * @param string $activity_type The activity type
     * @param string $message The message to be logged
     * @param ?array $log_details Other details to be logged
     */
    public static function super_success_log(string $activity_type, string $message = "", ?array $log_details = null){
        self::add_log($activity_type, $message, true, log_details: $log_details);
    }

    /**
     * Error logs which includes superadmin access
     * @param string $activity_type The activity type
     * @param string $message The message to be logged
     * @param ?array $log_details Other details to be logged
     */
    public static function super_error_log(string $activity_type, string $message = "", ?array $log_details = null){
        self::add_log($activity_type, $message, true, is_error: true, log_details: $log_details);
    }

    /**
     * Success logs which seen only by dev users
     * @param string $activity_type The activity type
     * @param string $message The message to be logged
     * @param ?array $log_details Other details to be logged
     */
    public static function dev_success_log(string $activity_type, string $message = "", ?array $log_details = null){
        self::add_log($activity_type, $message, add_admin: true, admin_level: 1, log_details: $log_details);
    }

    /**
     * Error logs which seen only by dev users
     * @param string $activity_type The activity type
     * @param string $message The message to be logged
     * @param ?array $log_details Other details to be logged
     */
    public static function dev_error_log(string $activity_type, string $message = "", ?array $log_details = null){
        self::add_log($activity_type, $message, add_admin: true, admin_level: 1, is_error:true, log_details: $log_details);
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

    /**
     * The school this belongs to
     */
    public function school() :BelongsTo{
        return $this->belongsTo(School::class);
    }
}
