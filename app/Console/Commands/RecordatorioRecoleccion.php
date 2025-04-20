<?php

namespace App\Console\Commands;

use App\Models\Assignment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\RecordatorioRecoleccionHogar;
use App\Mail\RecordatorioRecoleccionReciclador;

class RecordatorioRecoleccion extends Command
{
    protected $signature = 'recolecciones:recordatorio';
    protected $description = 'Enviar recordatorio de recolección a hogar y reciclador';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Obtener todas las recolecciones con estado 3 (Aprobadas) y la fecha programada en 1 hora
        $recolecciones = Assignment::where('state_id', 3)
            ->where('assignment_date', '<=', now()->addHour()) // Recolecciones programadas para dentro de una hora
            ->get();

        foreach ($recolecciones as $recoleccion) {
            // Enviar correo al hogar
            Mail::to($recoleccion->hogar->email)->send(new RecordatorioRecoleccionHogar($recoleccion));

            // Enviar correo al reciclador
            Mail::to($recoleccion->reciclador->email)->send(new RecordatorioRecoleccionReciclador($recoleccion));
        }

        $this->info('Correos enviados: ' . $recolecciones->count());
    }
}
