<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    public static array $settings = [
        [
            "name" => "attendance", "visual_name" => "Total Class Attendance", "default_value" => 80,
            "role_access" => "1-2-3-4", "input_type" => "number",
            "placeholder" => "Maximum Class Attendance [80]", "options" => "max=80"
        ],
        [
            "name" => "max_form", "visual_name" => "Highest Form Level", "default_value" => 3,
            "role_access" => "1-2-3-4", "input_type" => "number",
            "placeholder" => "Highest Form Level"
        ],
        [
            "name" => "r_date", "visual_name" => "Reopening Date",
            "role_access" => "1-2-3-4", "input_type" => "date"
        ],
        [
            "name" => "v_date", "visual_name" => "Vacation Date",
            "role_access" => "1-2-3-4", "input_type" => "date"
        ],
        [
            "name" => "roll_number", "visual_name" => "Number on Roll",
            "role_access" => "1-2-3-4", "input_type" => "number",
            "placeholder" => "Number on Roll"
        ],
        [
            "name" => "academic_year", "visual_name" => "Current Academic Year",
            "role_access" => "1-2-3", "input_type" => "text", "default_value" => "func get_academic_year(now())",
            "placeholder" => "Current Academic Year"
        ],
        [
            "name" => "academic_start", "visual_name" => "Month Academic year starts",
            "role_access" => "1-2-3", "default_value" => "September", "input_type" => "text",
            "placeholder" => "Start of Academic Year [Eg. September]", "options" => null
        ],
        [
            "name" => "academic_end", "visual_name" => "Month Academic year ends",
            "role_access" => "1-2-3", "input_type" => "text", "default_value" => "October",
            "placeholder" => "End of Academic Year [Eg. October]", "options" => null
        ],
        [
            "name" => "system_price", "visual_name" => "System Price",
            "role_access" => "1-2-3", "input_type" => "decimal", "default_value" => 6,
            "placeholder" => "Results Price", "options" => "step=0.1"
        ],
        [
            "name" => "result_max", "visual_name" => "Result Price Limit",
            "role_access" => "1-2", "input_type" => "decimal", "default_value" => 4,
            "placeholder" => "Schools Result Price Limit", "options" => "step=0.1"
        ],
        // ["name" => "", "visual_name" => "", "default_value" => "", "role_access" => "", "input_type" => "", "placeholder" => "", "options" => ""]
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // disable foreign key checks
        DB::statement("SET FOREIGN_KEY_CHECKS=0");

        Settings::truncate();

        // enable temporal foreign key check
        DB::statement("SET FOREIGN_KEY_CHECKS=1");

        // create the default settings
        foreach(self::$settings as $setting){
            Settings::create($setting);
        }
    }
}
