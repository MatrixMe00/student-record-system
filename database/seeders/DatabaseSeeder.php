<?php

namespace Database\Seeders;

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
        // Disable foreign key checks (MySQL/PostgreSQL)
        $this->disableForeignKeyChecks();

        // Truncate tables to start fresh
        Role::truncate();
        Settings::truncate();
        User::truncate();

        // Re-enable foreign key checks
        $this->enableForeignKeyChecks();

        // Reset system setup file
        $this->resetSystemFile();

        // Seed roles
        $this->seedRoles();

        // Seed system user
        $this->seedSystemUser();

        // Seed default settings
        $this->seedSettings();
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

    /**
     * Reset the system setup file
     */
    private function resetSystemFile(): void
    {
        $disk = env('FILESYSTEM_DISK', 'public');
        try {
            Storage::disk($disk)->delete('super.txt');
        } catch (\Exception $e) {
            // File doesn't exist, which is fine
        }
    }

    /**
     * Seed default roles
     */
    private function seedRoles(): void
    {
        $roles = [
            ["name" => "developer", "access_value" => 5],
            ["name" => "superadmin", "access_value" => 4],
            ["name" => "admin", "access_value" => 3],
            ["name" => "teacher", "access_value" => 3],
            ["name" => "student", "access_value" => 3]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }

    /**
     * Seed the system user (developer role)
     */
    private function seedSystemUser(): void
    {
        // Create system user with developer role
        $user = User::create([
            "id" => 0,
            "email" => "admin@edurecordsgh.com",
            "username" => "system",
            "password" => "system@edurecordsgh", // Will be automatically hashed by User model
            "role_id" => 1 // Developer role
        ]);

        // Create associated admin record
        Admin::create([
            "user_id" => $user->id,
            "lname" => "System",
            "oname" => "EdurecordsGH",
            "primary_phone" => "0"
        ]);
    }

    /**
     * Seed default system settings
     */
    private function seedSettings(): void
    {
        $settings = SettingsSeeder::$settings;

        foreach ($settings as $setting) {
            Settings::create($setting);
        }
    }
}
