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
        Schema::create('approveresults', function (Blueprint $table) {
            $table->id();
            $table->string("result_token")->unique();
            $table->foreignId("school_id")->constrained()->cascadeOnDelete();
            $table->foreignId("program_id")->constrained();
            $table->foreignId("teacher_id")->constrained("teachers", "user_id");
            $table->integer("semester");
            $table->enum("status", ["pending","reject", "accept"])->default("pending");
            $table->foreignId("admin_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approveresults');
    }
};
