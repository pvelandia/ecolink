<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function assignmentMaterials()
    {
        return $this->hasMany(AssignmentMaterial::class);
    }
    public function assignments()
{
    return $this->belongsToMany(Assignment::class, 'assignment_materials')
                ->withPivot('quantity')
                ->withTimestamps();
}

}
