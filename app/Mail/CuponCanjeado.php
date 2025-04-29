<?php
namespace App\Mail;

use App\Models\Coupon;
use App\Models\CouponRedemption;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CuponCanjeado extends Mailable
{
    use Queueable, SerializesModels;

    public $coupon;
    public $user;
    public $redemption;

    // Constructor para recibir los datos del cupón, el usuario y el canje
    public function __construct(Coupon $coupon, User $user, CouponRedemption $redemption)
    {
        $this->coupon = $coupon;
        $this->user = $user;
        $this->redemption = $redemption;
    }

    // El método build para construir el correo
    public function build()
    {
        $email = $this->view('emails.cuponCanjeado')
                      ->with([
                          'coupon' => $this->coupon,
                          'user' => $this->user,
                          'redemption' => $this->redemption,
                      ])
                      ->subject('¡Tu cupón ha sido canjeado con éxito!');

        // Si el cupón tiene una imagen, adjuntarla al correo
        if ($this->coupon->image) {
            $imagePath = public_path('storage/' . $this->coupon->image);
            $email->attach($imagePath, [
                'as' => 'coupon-image.jpg', // Puedes cambiar el nombre del archivo
                'mime' => 'image/jpeg', // Especifica el tipo de archivo, cambia si es otro formato
            ]);
        }

        return $email;
    }
}
