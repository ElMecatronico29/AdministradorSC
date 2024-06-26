<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoProyecto extends Model
{
    use HasFactory;
    protected $fillable = [
        'objetivo_general',
        'objetivo_especifico',
        'proyecto_id'
    ];
    
}
