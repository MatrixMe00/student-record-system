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
        Schema::create('deletedusers', function (Blueprint $table) {
            $table->integer("user_id");
            $table->string("lname");
            $table->string("oname");
            $table->string("email")->nullable();
            $table->string("phone_number");
            $table->string("secondary_phone")->nullable();
            $table->foreignId("role_id")->constrained()->cascadeOnUpdate();
            $table->foreignId("school_id")->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deletedusers');
    }
};
