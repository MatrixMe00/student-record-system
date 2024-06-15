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
        Schema::create('admins', function (Blueprint $table) {
            $table->foreignId("user_id")->constrained()->cascadeOnDelete()->primary();
            $table->string("lname");
            $table->string("oname");
            $table->string("primary_phone");
            $table->string("secondary_phone")->nullable();
            $table->foreignId("school_id")->nullable();
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
        Schema::dropIfExists('admins');
    }
};
