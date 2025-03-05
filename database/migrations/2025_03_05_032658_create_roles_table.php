<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique(); // Nombre del rol (Ej: Escritor, Cliente, Admin)
            $table->timestamps();
        });

        // Insertar roles iniciales
        DB::table('roles')->insert([
            ['nombre' => 'Recolector'],
            ['nombre' => 'Hogar'],
         
        ]);
    }

    public function down(): void {
        Schema::dropIfExists('roles');
    }
};
