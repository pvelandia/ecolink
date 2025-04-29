<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Models\Coupon;
use App\Models\CouponRedemption;
use App\Mail\CuponCanjeado;
use App\Models\User;
use Illuminate\Http\Request;

class BonificacionController extends Controller
{
    public function index()
    {
        $cupones = Coupon::all();
        $user = auth()->user();
        $points = $user->points;

        $canjeados = CouponRedemption::where('user_id', $user->id)
            ->with('coupon')
            ->get();

        return view('hogar.bonificacion', compact('cupones', 'points', 'canjeados'));
    }

    public function canjear($couponId, Request $request)
{
    $coupon = Coupon::findOrFail($couponId);
    $user = auth()->user();

    if ($user->points >= $coupon->points && $coupon->stock > 0) {
        // Restar puntos al usuario
        $user->points -= $coupon->points;
        $user->save();

        // Restar stock al cupón
        $coupon->stock -= 1;
        $coupon->save();

        // Registrar el canje y guardar la instancia
        $redemption = CouponRedemption::create([
            'coupon_id' => $coupon->id,
            'user_id'   => $user->id,
            'redeemed_at' => now(),
        ]);

        // Enviar correo incluyendo el número de canje (ID)
        Mail::to($user->email)->send(new CuponCanjeado($coupon, $user, $redemption));

        return redirect()->route('hogar.bonificacion')->with('success', 'Cupón canjeado correctamente.');
    } else {
        return redirect()->route('hogar.bonificacion')->with('error', 'No tienes suficientes puntos o el cupón está agotado.');
    }
}

    public function reenviarCorreo($id)
    {
        $redemption = \App\Models\CouponRedemption::with('coupon')->findOrFail($id);
        $user = auth()->user();

        // Verifica que el canje pertenece al usuario autenticado
        if ($redemption->user_id !== $user->id) {
            return redirect()->back()->with('error', 'No tienes permiso para reenviar este correo.');
        }

        $coupon = $redemption->coupon;

        // Reenviar el correo
        Mail::to($user->email)->send(new \App\Mail\CuponCanjeado($coupon, $user, $redemption));

        return redirect()->back()->with('success', 'El correo ha sido reenviado exitosamente.');
    }
}
