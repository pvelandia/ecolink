<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponRedemption extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'coupon_id',   // Aquí añadimos el campo coupon_id
        'user_id',
        'redeemed_at',
    ];
    // Nombre de la tabla (si no sigue la convención, se puede agregar manualmente)
    protected $table = 'coupon_redemptions'; 

    // Si la tabla tiene una clave primaria diferente a 'id', especifícalo aquí
    protected $primaryKey = 'id';

    // Si la tabla no tiene campos de marca de tiempo, se puede agregar esta línea
    public $timestamps = true; 

    // Definir la relación con el modelo Coupon
    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id'); // Relaciona la tabla con el modelo Coupon
    }
    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

}