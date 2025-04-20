<?php

namespace App\Mail;

use App\Models\Assignment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecordatorioRecoleccionReciclador extends Mailable
{
    use Queueable, SerializesModels;

    public $recoleccion;

    public function __construct(Assignment $recoleccion)
    {
        $this->recoleccion = $recoleccion;
    }

    public function build()
    {
        return $this->view('emails.recoleccion-reciclador')  // Vista del correo para el reciclador
            ->with([
                'recoleccion' => $this->recoleccion,
            ]);
    }
}
