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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string("school_name")->unique();
            $table->string("school_slug");
            $table->string("logo_path")->nullable();
            $table->string("location");
            $table->string("gps_address", 15);
            $table->string("box_number")->unique();
            $table->text("description");
            $table->string("school_email");
            $table->foreignId("admin_id")->constrained("admins","user_id")->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
