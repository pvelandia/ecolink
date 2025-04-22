<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class roles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Reciclador'],
            ['id' => 2, 'name' => 'Hogar'],
            ['id' => 3, 'name' => 'Administrador'],
            ['id' => 4, 'name' => 'Bloqueado'],
            // Puedes agregar más registros aquí si es necesario
        ]);
    }
}
