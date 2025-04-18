<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = ['company', 'description', 'discount', 'stock', 'points', 'stock_inicial'];

    public function getNumeroCuponAttribute()
    {
        return ($this->stock_inicial - $this->stock);
    }

}
