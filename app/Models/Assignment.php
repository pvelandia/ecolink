<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'person_id',
        'recycler_id',
        'assignment_date',
        'address',
        'state_id', // si tienes estado
    ];    

    // Relación con el hogar
    public function hogar()
    {
        return $this->belongsTo(User::class, 'person_id');
    }

    // Relación con el reciclador (quien acepta)
    public function reciclador()
    {
        return $this->belongsTo(User::class, 'recycler_id');
    }

    // Si hay una relación con materiales:
    public function materials()
    {
        return $this->belongsToMany(Material::class, 'assignment_materials')->withPivot('quantity');
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function assignmentMaterials()
    {
        return $this->hasMany(AssignmentMaterial::class);
    }
}
