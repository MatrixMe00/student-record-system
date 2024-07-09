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
        Schema::create('payment_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->cascadeOnDelete();
            $table->foreignId("school_id")->nullable()->constrained()->nullOnDelete();
            $table->string("bank_code")->nullable();
            $table->string("account_number");
            $table->string("account_name");
            $table->string("account_id")->unique();
            $table->string("split_key")->nullable();
            $table->enum("type", ["school", "individual"])->default("individual");
            $table->boolean("master")->default(false);
            $table->boolean("status")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_information');
    }
};
