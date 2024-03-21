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
        Schema::create('teachers_remarks', function (Blueprint $table) {
            $table->id();
            $table->string("remark_token")->unique();
            $table->foreignId("school_id")->constrained();
            $table->foreignId("teacher_id")->constrained("teachers", "user_id");
            $table->foreignId("program_id")->constrained();
            $table->integer("semester");
            $table->integer("total_attendance")->nullable();
            $table->enum("status", ["pending", "rejected", "accepted"])->default("pending");
            $table->foreignId("admin_id")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers_remarks');
    }
};
