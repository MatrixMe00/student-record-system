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
        Schema::create('debtors_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId("school_id")->constrained();
            $table->foreignId("student_id")->constrained("students", "user_id");
            $table->string("payment_type")->default("debt");
            $table->float("amount");
            $table->boolean("status")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debtors_lists');
    }
};
