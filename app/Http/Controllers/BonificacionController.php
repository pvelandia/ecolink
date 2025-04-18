<?php
namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\User;  // El modelo User ya está relacionado con la tabla 'people'
use Illuminate\Http\Request;

class BonificacionController extends Controller
{
    public function index()
    {
        // Obtener todos los cupones
        $cupones = Coupon::all();

        // Obtener los puntos del usuario autenticado (ya que está en la tabla 'people')
        $user = auth()->user();
        $points = $user->points;

        // Pasar los cupones y los puntos a la vista
        return view('hogar.bonificacion', compact('cupones', 'points'));
    }

    public function canjear($couponId)
    {
        $coupon = Coupon::findOrFail($couponId);
        $user = auth()->user();
    
        // Verificar si ya tiene un cupón asignado
        if ($user->coupon_id !== null) {
            return redirect()->route('hogar.bonificacion')
                ->with('error', 'Ya tienes un cupón asignado. Envialo a tu correo antes de obtener uno nuevo.');
        }
    
        // Verificar si tiene suficientes puntos y si hay stock disponible
        if ($user->points >= $coupon->points && $coupon->stock > 0) {
            $user->points -= $coupon->points;
            $user->coupon_id = $coupon->id; // Asignar cupón al usuario
            $user->save();
    
            $coupon->stock -= 1;
            $coupon->save();
    
            return redirect()->route('hogar.bonificacion')->with('success', 'Cupón canjeado correctamente.');
        } else {
            return redirect()->route('hogar.bonificacion')->with('error', 'No tienes suficientes puntos o el cupón está agotado.');
        }
    }    
}
