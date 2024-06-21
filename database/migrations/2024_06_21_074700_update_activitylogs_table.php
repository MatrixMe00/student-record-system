<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table("activitylogs", function(Blueprint $table){
            $table->tinyInteger("admin_level")->after("user_id");
            $table->foreignId("school_id")->nullable()->after("activity_type")->constrained()->nullOnDelete();
            $table->boolean("add_admin")->default(false)->after("admin_level");
            $table->text("log_details")->nullable()->after("add_admin");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns("activitylogs", ["school_id", "admin_level", "add_admin", "log_details"]);
    }
};
