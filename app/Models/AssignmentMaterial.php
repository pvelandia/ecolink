<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'material_id',
        'quantity',
        'address',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
