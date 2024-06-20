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
            $table->string("next_of_kin")->nullable();
            $table->string("primary_phone")->nullable();
            $table->string("secondary_phone")->nullable();
            $table->foreignId("school_id")->nullable()->constrained()->nullOnDelete();
            $table->foreignId("program_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean("completed")->default(false);
            $table->boolean("is_deleted")->default(false);
            $table->boolean("is_active")->default(true);
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
