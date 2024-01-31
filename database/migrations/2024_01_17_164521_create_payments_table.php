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
        Schema::create('payments', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('reference')->unique();
            $table->foreignId('school_id')->constrained();
            $table->string("contact_name");
            $table->string("contact_email");
            $table->string("contact_phone");
            $table->string("payment_type");
            $table->foreignId("student_id")->constrained('students', 'user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
