<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Los comandos de Artisan proporcionados por tu aplicación.
     *
     * @var array
     */
    protected $commands = [
        // Aquí puedes registrar comandos personalizados si los tienes
    ];

    /**
     * Define las tareas programadas para tu aplicación.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Registra tus tareas programadas aquí
        $schedule->command('recolecciones:recordatorio')->hourly(); // Ejecutará el comando cada hora
    }

    /**
     * Registra los comandos Artisan disponibles para tu aplicación.
     *
     * @return void
     */
    protected function commands()
    {
        // Carga los comandos dentro de la carpeta `app/Console/Commands`
        $this->load(__DIR__.'/Commands');

        // Requiere el archivo `routes/console.php` para registrar comandos adicionales
        require base_path('routes/console.php');
    }
}
