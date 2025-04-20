<?php
namespace App\Mail;

use App\Models\Assignment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecordatorioRecoleccionHogar extends Mailable
{
    use Queueable, SerializesModels;

    public $recoleccion;

    public function __construct(Assignment $recoleccion)
    {
        $this->recoleccion = $recoleccion;
    }

    public function build()
{
    return $this->view('emails.recoleccion-hogar') // Asegúrate de que esta ruta sea correcta
        ->with([
            'recoleccion' => $this->recoleccion,
        ]);
}

}
