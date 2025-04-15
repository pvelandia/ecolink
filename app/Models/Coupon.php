<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = ['company', 'description', 'discount', 'stock', 'points'];

    public function people()
    {
        return $this->hasMany(Person::class);
    }
}
