<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;
    protected $fillable = ['titulo', 'descripcion', 'fecha_inicio', 'fecha_fin', 'estado','profesor_id','area_aplicacion'];

    public function profesore()
    {
        return $this->belongsTo(Profesore::class,'profesor_id');
    }

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class,'proyecto_id');
    }

    
}
