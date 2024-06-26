<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfesorEncargadoPorCarrera extends Model
{
    use HasFactory;

    protected $fillable = [
        'Carrera',
        'profesor_id'
    ];

    // Definir la relación con el modelo Profesor
    public function profesore()
    {
        return $this->belongsTo(Profesore::class);
    }
}
