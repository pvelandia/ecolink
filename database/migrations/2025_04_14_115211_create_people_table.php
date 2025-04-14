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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('coupon_id')->nullable(); // Por si no todos tienen cupón
            $table->string('first_name');
            $table->string('last_name');
            $table->string('document')->unique();
            $table->string('phone_number');
            $table->string('password');
            $table->decimal('average', 5, 2)->nullable();
            $table->integer('bonuses')->default(0);
            $table->timestamps();
        
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('coupon_id')->references('id')->on('coupons');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
