<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitude extends Model
{
    use HasFactory;
    protected $fillable = ['titulo', 'descripcion','tutor_solicitado','areaAplicacion'];

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class,'solicitud_id');
    }
   
}
