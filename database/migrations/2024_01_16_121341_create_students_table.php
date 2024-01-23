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
        Schema::create('students', function (Blueprint $table) {
            $table->foreignId("user_id")->primary()->constrained()->cascadeOnDelete();
            $table->string("lname");
            $table->string("oname");
            $table->string("next_of_kin");
            $table->string("primary_phone");
            $table->string("secondary_phone")->nullable();
            $table->foreignId("school_id")->constrained()->nullOnDelete();
            $table->foreignId("program_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};