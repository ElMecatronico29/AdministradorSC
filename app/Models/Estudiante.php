<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;
    protected $fillable = ['usuario_id', 'carrera', 'proyecto_id','solicitud_id'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class,'usuario_id');
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class,'proyecto_id');
    }
    public function solicitude()
    {
        return $this->belongsTo(Solicitude::class,'solicitud_id');
    }
}
