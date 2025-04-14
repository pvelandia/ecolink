<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'document',
        'email',
        'phone_number',
        'password',
        'average',
        'bonuses',
        'role_id',
        'coupon_id',
    ];
    protected $table = 'people'; 
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
