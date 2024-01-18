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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId("student_id")->constrained("students","user_id");
            $table->foreignId("teacher_id")->constrained("teachers", "user_id");
            $table->foreignId("program_id")->constrained()->cascadeOnDelete();
            $table->foreignId("school_id")->constrained()->cascadeOnDelete();
            $table->integer("semester");
            $table->float("class_mark");
            $table->float("exam_mark");
            $table->string("result_token")->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
