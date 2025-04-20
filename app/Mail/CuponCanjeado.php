<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CuponCanjeado extends Mailable
{
    use Queueable, SerializesModels;

    public $cupon, $user, $redemption;

public function __construct($cupon, $user, $redemption)
{
    $this->cupon = $cupon;
    $this->user = $user;
    $this->redemption = $redemption;
}

    public function build()
    {
        return $this->subject('¡Cupón Canjeado! ')
                    ->view('emails.cuponCanjeado');
    }
}
