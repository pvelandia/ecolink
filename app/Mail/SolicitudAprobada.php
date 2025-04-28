<?php


namespace App\Mail;

use App\Models\Assignment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SolicitudAprobada extends Mailable
{
    use Queueable, SerializesModels;

    public $solicitud;

    public function __construct(Assignment $solicitud)
    {
        $this->solicitud = $solicitud;
    }

    public function build()
    {
        return $this->subject('Solicitud de Recolección Aprobada')
                    ->view('emails.solicitud_aprobada');
    }
}
