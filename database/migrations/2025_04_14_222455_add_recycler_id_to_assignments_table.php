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
    Schema::table('assignments', function (Blueprint $table) {
        $table->unsignedBigInteger('recycler_id')->nullable()->after('person_id');

        // Agrega la relación con la tabla people (si aplica)
        $table->foreign('recycler_id')->references('id')->on('people')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('assignments', function (Blueprint $table) {
        $table->dropForeign(['recycler_id']);
        $table->dropColumn('recycler_id');
    });
}

};
