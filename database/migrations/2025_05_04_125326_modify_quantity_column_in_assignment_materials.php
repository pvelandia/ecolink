<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyQuantityColumnInAssignmentMaterials extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('assignment_materials', function (Blueprint $table) {
            $table->decimal('quantity', 8, 2)->change(); // Cambiar la columna a decimal
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assignment_materials', function (Blueprint $table) {
            $table->integer('quantity')->change(); // Restaurar a integer
        });
    }
};
