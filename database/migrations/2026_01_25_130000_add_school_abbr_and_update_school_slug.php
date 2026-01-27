<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            // Add school_abbr column (nullable)
            $table->string('school_abbr')->nullable()->after('school_name');
            
            // Make school_slug unique and nullable temporarily
            $table->string('school_slug')->nullable()->unique()->change();
        });

        // Generate slugs for existing schools from their names
        DB::table('schools')->get()->each(function ($school) {
            $slug = Str::slug($school->school_name);
            // Ensure uniqueness
            $originalSlug = $slug;
            $counter = 1;
            while (DB::table('schools')->where('school_slug', $slug)->where('id', '!=', $school->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            DB::table('schools')
                ->where('id', $school->id)
                ->update([
                    'school_slug' => $slug,
                    'school_abbr' => $school->school_slug // Migrate old slug to abbreviation
                ]);
        });

        // Make school_slug not nullable after migration
        Schema::table('schools', function (Blueprint $table) {
            $table->string('school_slug')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            // Migrate school_abbr back to school_slug if school_slug is null
            DB::table('schools')->whereNull('school_slug')->update([
                'school_slug' => DB::raw('school_abbr')
            ]);
            
            $table->dropColumn('school_abbr');
            $table->string('school_slug')->nullable(false)->unique(false)->change();
        });
    }
};
