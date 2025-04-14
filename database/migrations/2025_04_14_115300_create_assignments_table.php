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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('state_id');
            $table->dateTime('assignment_date');
            $table->decimal('rating', 3, 2)->nullable(); // Ej: 4.5
            $table->timestamps();
        
            $table->foreign('person_id')->references('id')->on('people');
            $table->foreign('state_id')->references('id')->on('states');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
