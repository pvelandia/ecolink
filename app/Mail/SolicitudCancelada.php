<?php

namespace App\Mail;

use App\Models\Assignment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SolicitudCancelada extends Mailable
{
    use Queueable, SerializesModels;

    public $solicitud;
    public $reciclador;

    public function __construct(Assignment $solicitud,$reciclador)
    {
        $this->solicitud = $solicitud;
        $this->reciclador = $reciclador;
    }

    public function build()
    {
        return $this->subject('Recolección Cancelada')
                    ->view('emails.recoleccion_Cancelada');
    }
}