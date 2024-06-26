<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    protected $fillable = ['cedula','correo', 'contrasena', 'nombre', 'apellido', 'tipo'];

    public function profesore()
    {
        return $this->hasOne(Profesore::class);
    }

    public function estudiante()
    {
        return $this->hasOne(Estudiante::class);
    }
}
