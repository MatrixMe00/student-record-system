<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\Settings;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::truncate();
        Settings::truncate();

        $roles = [
            ["name" => "developer", "access_value" => 5],
            ["name" => "superadmin", "access_value" => 4],
            ["name" => "admin", "access_value" => 3],
            ["name" => "teacher", "access_value" => 3],
            ["name" => "student", "access_value" => 3]
        ];
        $settings = [
            ["name" => "attendance", "visual_name" => "Total Class Attendance", "role_access" => "1-2-3-4"],
            ["name" => "max_form", "visual_name" => "Highest Form Level", "default_value" => 3, "role_access" => "1-2-3-4"],
            ["name" => "r_date", "visual_name" => "Reopening Date", "role_access" => "1-2-3-4"],
            ["name" => "v_date", "visual_name" => "Vacation Date", "role_access" => "1-2-3-4"],
            ["name" => "roll_number", "visual_name" => "Number on Roll", "role_access" => "1-2-3-4"],
            ["name" => "head_signature", "visual_name" => "Headmaster's Signature", "role_access" => "1-2-3"]
            // ["name" => "", "visual_name" => "", "role_access" => ""]
        ];

        // create the roles
        foreach($roles as $role){
            Role::create($role);
        }

        // create the default settings
        foreach($settings as $setting){
            Settings::create($setting);
        }

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
