<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class materials extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('materials')->insert([
            ['id' => 1, 'name' => 'Plastico'],
            ['id' => 2, 'name' => 'Carton'],
            ['id' => 3, 'name' => 'Vidrio'],
            ['id' => 4, 'name' => 'Residuos Organicos'],
            ['id' => 5, 'name' => 'Regiduos Electronicos'],
        ]);
    }
}
