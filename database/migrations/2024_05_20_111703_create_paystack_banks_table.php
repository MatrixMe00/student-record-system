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
        Schema::create('paystack_banks', function (Blueprint $table) {
            $table->id();
            $table->integer("code")->unique();
            $table->enum("type", ["ghipss", "mobile_money"]);
            $table->string("name");
            $table->string("slug")->unique();
            $table->string("country");
            $table->string("currency");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paystack_banks');
    }
};
