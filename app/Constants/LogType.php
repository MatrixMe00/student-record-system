<?php
    namespace App\Constants;

    class LogType{
        private static ?self $instance = null;
        /// USER AUTHENTICATION CONSTANTS
        const USER_LOGIN = "login";
        const USER_LOGOUT = "logout";

        /// PROFILE BASED CONSTANTS
        const ACCOUNT_CREATE = "account-create";
        const ACCOUNT_UPDATE = "account-update";
        const ACCOUNT_DELETE = "account-delete";
        const PASSWORD_CHANGE = "password-update";
        const EMAIL_VERIFY = "email-verify";

        const SCHOOL_UPDATE = "school-update";
        const SCHOOL_ADD = "school-add";

        /// System settings
        const SYSTEM_INFO = "system-info";

        /// payment information
        const SUB_ACCOUNT_CREATE = "sub-account-create";
        const SUB_ACCOUNT_UPDATE = "sub-account-update";

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
                "school-update" => "fas fa-edit", "school-add" => "fas fa-school", "account-create" => "fas fa-user-plus",
                "account-delete" => "fas fa-user-times", "password-update" => "fas fa-key", "email-verify" => "fas fa-envelope-open-text",
                "system-info" => "fas fa-info-circle", "sub-account-create" => "fas fa-wallet", "sub-acccount-update" => "fas fa-sync-alt"
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
