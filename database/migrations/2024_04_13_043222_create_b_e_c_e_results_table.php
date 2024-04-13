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
        Schema::create('bece_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId("student_id")->constrained("students", "user_id")->cascadeOnDelete();
            $table->foreignId("school_id")->constrained()->cascadeOnDelete();
            $table->mediumText("results");
            $table->integer("raw_score");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b_e_c_e_results');
    }
};
