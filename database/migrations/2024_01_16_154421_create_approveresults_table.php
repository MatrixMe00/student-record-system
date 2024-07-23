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
        Schema::create('approveresults', function (Blueprint $table) {
            $table->id();
            $table->string("result_token")->unique();
            $table->foreignId("school_id")->constrained()->cascadeOnDelete();
            $table->foreignId("program_id")->constrained()->cascadeOnDelete();
            $table->foreignId("subject_id")->constrained()->cascadeOnDelete();
            $table->foreignId("teacher_id")->constrained("teachers", "user_id");
            $table->integer("semester");
            $table->enum("status", ["pending","rejected", "accepted", "submitted"])->default("pending");
            $table->enum("remark_status", ["pending","accepted","rejected"])->default("pending");
            $table->foreignId("admin_id")->nullable();
            $table->string("academic_year", 16);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approveresults');
    }
};
