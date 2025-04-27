<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Materials extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('materials')->insert([
            [
                'id' => 1,
                'name' => 'Carton',
                'points_kilo' => 9,
                'description' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Archivo',
                'points_kilo' => 20,
                'description' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Tetrapack',
                'points_kilo' => 5,
                'description' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Vidrio',
                'points_kilo' => 3,
                'description' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'name' => 'PET vidrio',
                'points_kilo' => 54,
                'description' => 'Envases o botellas de vidrio (sin tapas).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'name' => 'PET plastico',
                'points_kilo' => 15,
                'description' => 'Botellas (sin tapas).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'name' => 'Plastico Rígido',
                'points_kilo' => 39,
                'description' => 'Botellas de detergente, Botellones, Tuberías, Carcasas de dispositivos.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'name' => 'Plastico Flexible',
                'points_kilo' => 21,
                'description' => 'Bolsas plásticas, envolturas, tapas de botellas, envases flexibles de alimentos.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'name' => 'Chatarra',
                'points_kilo' => 22,
                'description' => 'Todo tipo de metales o dispositivos (sin baterías).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'name' => 'Aluminio',
                'points_kilo' => 103,
                'description' => 'Latas, objetos 100% en aluminio.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}