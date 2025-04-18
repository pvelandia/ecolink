<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\CouponRedemption;
use App\Models\User;
use Illuminate\Http\Request;

class BonificacionController extends Controller
{
    public function index()
    {
        // Obtener todos los cupones disponibles
        $cupones = Coupon::all();
    
        // Obtener los puntos del usuario autenticado (ya que está en la tabla 'people')
        $user = auth()->user();
        $points = $user->points;
    
        // Obtener los cupones que el usuario ya ha canjeado
        $canjeados = \App\Models\CouponRedemption::where('user_id', $user->id)
            ->with('coupon')  // Relación con el cupón
            ->get();
    
        // Pasar los cupones disponibles, los puntos y los canjeados a la vista
        return view('hogar.bonificacion', compact('cupones', 'points', 'canjeados'));
    }    

    public function canjear($couponId, Request $request)
    {
        $coupon = Coupon::findOrFail($couponId);
        $user = auth()->user();

        // Verificar si tiene suficientes puntos y si hay stock disponible
        if ($user->points >= $coupon->points && $coupon->stock > 0) {
            // Restar puntos al usuario
            $user->points -= $coupon->points;
            $user->save();

            // Restar stock al cupón
            $coupon->stock -= 1;
            $coupon->save();

            // Registrar el canje en la tabla de coupon_redemptions
            \App\Models\CouponRedemption::create([
                'coupon_id' => $coupon->id,
                'user_id'   => $user->id,
                'redeemed_at' => now(),
            ]);

            return redirect()->route('hogar.bonificacion')->with('success', 'Cupón canjeado correctamente.');
        } else {
            return redirect()->route('hogar.bonificacion')->with('error', 'No tienes suficientes puntos o el cupón está agotado.');
        }
    }     
}