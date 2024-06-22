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
            $table->boolean("is_error")->default(false)->after("log_details");
            $table->string("ip_address")->after("is_error");
            $table->string("user_agent")->after("ip_address");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activitylogs', function (Blueprint $table) {
            // Dropping the foreign key constraint and then the column
            $table->dropForeign(['school_id']);
            $table->dropColumn('school_id');

            // Dropping the other columns
            $table->dropColumn(['admin_level', 'add_admin', 'log_details', 'is_error', 'ip_address', 'user_agent']);
        });
    }
};
