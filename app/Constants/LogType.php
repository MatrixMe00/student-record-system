<?php
    namespace App\Constants;

    class LogType{
        private static ?self $instance = null;
        /// USER AUTHENTICATION CONSTANTS
        /**
         * @var string USER_LOGIN
         */
        const USER_LOGIN = "login";
        /**
         * @var string USER_LOGIN
         */
        const USER_LOGOUT = "logout";

        /// PROFILE BASED CONSTANTS
        /**
         * @var string ACCOUNT_UPDATE
         */
        const ACCOUNT_UPDATE = "account-update";
        /**
         * @var string SCHOOL_UPDATE
         */
        const SCHOOL_UPDATE = "school-update";
        /**
         * @var string SCHOOL_ADD
         */
        const SCHOOL_ADD = "school-add";

        /**
         * Kick start the class
         */
        public static function boot(){
            if(is_null(self::$instance)){
                $instance = new self;
            }

            return self::$instance;
        }

        /**
         * Returns all the registered activity logs and their respective icons
         */
        private static function activity_logs() :array{
            $logs = [
                "login" => "fas fa-sign-in-alt", "logout" => "fas fa-sign-out-alt", "account-update" => "fas fa-user-edit",
                "school-update" => "fas fa-edit", "school-add" => "fas fa-school"
            ];

            return $logs;
        }

        /**
         * Returns all the log constants in this file
         * @return array
         */
        public static function activity_log_constants() :array{
            return array_keys(self::activity_logs());
        }

        /**
         * Returns icons associated with a log
         * @param string $activity_type The type of activity
         * @return ?string
         */
        public static function activity_icon(string $activity_type) :?string{
            return self::activity_logs()[$activity_type];
        }
    }
