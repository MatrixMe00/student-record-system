<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    public static array $settings = [
        // Academic Calendar Settings (Accessible by Developer, Superadmin, Admin, Teacher)
        [
            "name" => "attendance",
            "visual_name" => "Total Class Attendance",
            "default_value" => "80",
            "role_access" => "1-2-3-4",
            "type" => "number",
            "placeholder" => "Maximum Class Attendance [80]",
            "options" => "max=100,min=1"
        ],
        [
            "name" => "max_form",
            "visual_name" => "Highest Form Level",
            "default_value" => "3",
            "role_access" => "1-2-3-4",
            "type" => "number",
            "placeholder" => "Highest Form Level",
            "options" => "min=1,max=6"
        ],
        [
            "name" => "r_date",
            "visual_name" => "Reopening Date",
            "default_value" => null,
            "role_access" => "1-2-3-4",
            "type" => "date",
            "placeholder" => "Select Reopening Date",
            "options" => null
        ],
        [
            "name" => "v_date",
            "visual_name" => "Vacation Date",
            "default_value" => null,
            "role_access" => "1-2-3-4",
            "type" => "date",
            "placeholder" => "Select Vacation Date",
            "options" => null
        ],
        [
            "name" => "roll_number",
            "visual_name" => "Number on Roll",
            "default_value" => "0",
            "role_access" => "1-2-3-4",
            "type" => "number",
            "placeholder" => "Number on Roll",
            "options" => "min=0"
        ],

        // Academic Year Settings (Accessible by Developer, Superadmin, Admin)
        [
            "name" => "academic_year",
            "visual_name" => "Current Academic Year",
            "default_value" => "func get_academic_year(now())",
            "role_access" => "1-2-3",
            "type" => "text",
            "placeholder" => "Current Academic Year",
            "options" => null
        ],
        [
            "name" => "academic_start",
            "visual_name" => "Month Academic Year Starts",
            "default_value" => "September",
            "role_access" => "1-2-3",
            "type" => "text",
            "placeholder" => "Start of Academic Year [Eg. September]",
            "options" => null
        ],
        [
            "name" => "academic_end",
            "visual_name" => "Month Academic Year Ends",
            "default_value" => "October",
            "role_access" => "1-2-3",
            "type" => "text",
            "placeholder" => "End of Academic Year [Eg. October]",
            "options" => null
        ],

        // Payment Settings (Accessible by Developer, Superadmin, Admin)
        [
            "name" => "system_price",
            "visual_name" => "System Price",
            "default_value" => "6",
            "role_access" => "1-2-3",
            "type" => "decimal",
            "placeholder" => "Results Price",
            "options" => "step=0.1,min=0"
        ],
        [
            "name" => "result_max",
            "visual_name" => "Result Price Limit",
            "default_value" => "4",
            "role_access" => "1-2",
            "type" => "decimal",
            "placeholder" => "Schools Result Price Limit",
            "options" => "step=0.1,min=0"
        ],

        // Grading System Settings (Accessible by Developer, Superadmin, Admin)
        [
            "name" => "pass_mark",
            "visual_name" => "Minimum Pass Mark",
            "default_value" => "40",
            "role_access" => "1-2-3",
            "type" => "number",
            "placeholder" => "Minimum Pass Mark (Percentage)",
            "options" => "min=0,max=100"
        ],
        [
            "name" => "class_mark_weight",
            "visual_name" => "Class Mark Weight (%)",
            "default_value" => "30",
            "role_access" => "1-2-3",
            "type" => "number",
            "placeholder" => "Class Mark Weight Percentage",
            "options" => "min=0,max=100"
        ],
        [
            "name" => "exam_mark_weight",
            "visual_name" => "Exam Mark Weight (%)",
            "default_value" => "70",
            "role_access" => "1-2-3",
            "type" => "number",
            "placeholder" => "Exam Mark Weight Percentage",
            "options" => "min=0,max=100"
        ],

        // Result Publication Settings (Accessible by Developer, Superadmin, Admin)
        [
            "name" => "auto_publish_results",
            "visual_name" => "Auto Publish Results",
            "default_value" => "false",
            "role_access" => "1-2-3",
            "type" => "select",
            "placeholder" => "Automatically publish results after approval",
            "options" => "options=true|false"
        ],
        [
            "name" => "result_publication_delay",
            "visual_name" => "Result Publication Delay (Days)",
            "default_value" => "0",
            "role_access" => "1-2-3",
            "type" => "number",
            "placeholder" => "Days to wait before publishing results",
            "options" => "min=0"
        ],

        // Semester/Term Settings (Accessible by Developer, Superadmin, Admin, Teacher)
        [
            "name" => "current_semester",
            "visual_name" => "Current Semester",
            "default_value" => "1",
            "role_access" => "1-2-3-4",
            "type" => "number",
            "placeholder" => "Current Semester (1 or 2)",
            "options" => "min=1,max=2"
        ],
        [
            "name" => "current_term",
            "visual_name" => "Current Term",
            "default_value" => "1",
            "role_access" => "1-2-3-4",
            "type" => "number",
            "placeholder" => "Current Term (1, 2, or 3)",
            "options" => "min=1,max=3"
        ],

        // System Configuration (Accessible by Developer, Superadmin only)
        [
            "name" => "max_students_per_class",
            "visual_name" => "Maximum Students Per Class",
            "default_value" => "50",
            "role_access" => "1-2",
            "type" => "number",
            "placeholder" => "Maximum number of students per class",
            "options" => "min=1"
        ],
        [
            "name" => "result_expiry_days",
            "visual_name" => "Result Expiry Days",
            "default_value" => "120",
            "role_access" => "1-2",
            "type" => "number",
            "placeholder" => "Number of days before result access expires",
            "options" => "min=1"
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks (MySQL/PostgreSQL)
        $this->disableForeignKeyChecks();

        Settings::truncate();

        // Re-enable foreign key checks
        $this->enableForeignKeyChecks();

        // Create the default settings
        foreach (self::$settings as $setting) {
            Settings::create($setting);
        }
    }

    /**
     * Disable foreign key checks based on database driver
     */
    private function disableForeignKeyChecks(): void
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        } elseif ($driver === 'pgsql') {
            DB::statement('SET session_replication_role = replica');
        }
        // SQLite doesn't need special handling for truncate
    }

    /**
     * Enable foreign key checks based on database driver
     */
    private function enableForeignKeyChecks(): void
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        } elseif ($driver === 'pgsql') {
            DB::statement('SET session_replication_role = DEFAULT');
        }
    }
}
