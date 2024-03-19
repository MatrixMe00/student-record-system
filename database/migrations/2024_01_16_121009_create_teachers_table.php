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
        Schema::create('teachers', function (Blueprint $table) {
            $table->foreignId("user_id")->primary()->constrained()->cascadeOnDelete();
            $table->string("lname");
            $table->string("oname");
            $table->string("primary_phone");
            $table->string("secondary_phone")->nullable();
            $table->foreignId("school_id")->nullable()->constrained()->nullOnDelete();
            $table->boolean("class_teacher")->default(false);
            $table->foreignId("program_id")->nullable()->comment("This is the class this teacher is class teacher of");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
