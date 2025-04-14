<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('assignment_materials', function (Blueprint $table) {
        $table->dropColumn('address');
    });
}

public function down()
{
    Schema::table('assignment_materials', function (Blueprint $table) {
        $table->string('address')->nullable();  // O el tipo de dato que tenía originalmente
    });
}

};
