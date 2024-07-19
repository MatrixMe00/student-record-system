<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\Role;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // disable foreign key checks
        DB::statement("SET FOREIGN_KEY_CHECKS=0");

        Role::truncate();
        Settings::truncate();
        User::truncate();

        // enable temporal foreign key check
        DB::statement("SET FOREIGN_KEY_CHECKS=1");


        // reset system
        Storage::disk('local')->delete('super.txt');

        $roles = [
            ["name" => "developer", "access_value" => 5],
            ["name" => "superadmin", "access_value" => 4],
            ["name" => "admin", "access_value" => 3],
            ["name" => "teacher", "access_value" => 3],
            ["name" => "student", "access_value" => 3]
        ];
        $settings = SettingsSeeder::$settings;

        // create the roles
        foreach($roles as $role){
            Role::create($role);
        }

        // create the system user
        $user = User::create([
            "id" => 0, "email" => "admin@edurecordsgh.com", "username" => "system",
            "password" => "system@edurecordsgh", "role_id" => 1
        ]);

        Admin::create([
            "user_id" => $user->id, "lname" => "System", "oname" => "EdurecordsGH", "primary_phone" => "0"
        ]);

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
