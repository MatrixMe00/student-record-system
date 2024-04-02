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
        Schema::create('teacher_remarks', function (Blueprint $table) {
            $table->id();
            $table->string("remark_token");
            $table->foreignId("school_id")->constrained()->cascadeOnDelete();
            $table->foreignId("teacher_id")->constrained("teachers", "user_id");
            $table->foreignId("program_id")->constrained()->cascadeOnDelete();
            $table->foreignId("student_id")->constrained("students", "user_id");
            $table->integer("semester");
            $table->integer("total_marks");
            $table->integer("attendance");
            $table->integer("position");
            $table->string("remark");
            $table->enum("status", ["pending", "accepted", "rejected", "submitted"])->default("pending");
            $table->boolean("promoted")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_remarks');
    }
};
