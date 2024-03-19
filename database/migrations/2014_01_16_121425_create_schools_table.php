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
            $table->enum("school_type", ["public", "private"]);
            $table->text("description");
            $table->string("school_email");
            $table->string("school_head");
            $table->foreignId("admin_id")->nullable();
            $table->timestamps();
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