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
        Schema::create('others', function (Blueprint $table) {
            $table->foreignId("user_id")->primary()->constrained()->cascadeOnDelete();
            $table->string("lname");
            $table->string("oname");
            $table->string("phone_number");
            $table->string("secondary_number")->nullable();
            $table->foreignId("school_id")->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('others');
    }
};
