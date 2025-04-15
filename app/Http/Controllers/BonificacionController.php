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
        $points = $user->bonuses;  // Acceder directamente al campo 'points' en la tabla 'people'

        // Pasar los cupones y los puntos a la vista
        return view('hogar.bonificacion', compact('cupones', 'points'));
    }

    public function canjear($id)
    {
        $user = auth()->user();
        $cupon = Coupon::findOrFail($id);

        // Verificar si el usuario tiene suficientes puntos
        if ($user->bonuses >= $cupon->points) {
            // Descontar los puntos del usuario
            $user->bonuses -= $cupon->points;
            $user->save();

            // Disminuir el stock del cupón
            $cupon->stock -= 1;
            $cupon->save();

            // Redirigir con un mensaje de éxito
            return redirect()->route('hogar.bonificacion')->with('success', '¡Cupón canjeado exitosamente!');
        }

        // Si no tiene suficientes puntos
        return redirect()->route('hogar.bonificacion')->with('error', 'No tienes suficientes puntos para canjear este cupón.');
    }
}
