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
        Schema::create('bece_candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId("student_id")->unique()->constrained("students", "user_id")->cascadeOnDelete();
            $table->foreignId("school_id")->constrained()->cascadeOnDelete();
            $table->string("index_number")->nullable();
            $table->string("student_token")->unique();
            $table->mediumText("placement")->nullable()->comment("Hashed value of the placement details");
            $table->string("result_checker", 60)->nullable();
            $table->string("placement_checker", 60)->nullable();
            $table->string("academic_year");
            $table->boolean("status")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bece_candidates');
    }
};
