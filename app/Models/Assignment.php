<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id',
        'state_id',
        'assignment_date',
        'address',
        'rating',
    ];
    public function materials()
    {
        return $this->belongsToMany(Material::class, 'assignment_materials')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
    

    public function user()
    {
        return $this->belongsTo(User::class, 'person_id');
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
