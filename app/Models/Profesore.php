<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesore extends Model
{
    use HasFactory;
    protected $fillable = ['usuario_id', 'departamento', 'proyecto_id'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class,'usuario_id');
    }

    public function proyectos()
    {
        return $this->hasMany(Proyecto::class,'profesor_id');
    }

    public function carreras()
    {
        return $this->hasMany(ProfesorEncargadoPorCarrera::class);
    }
}
