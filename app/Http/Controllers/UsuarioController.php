<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function crear(Request $request){
        
        $usuario = $request->validate([
            'cedula' => 'required|string|max:255',
            'correo' => 'required|string',
            'contrasena' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:45',
            'tipo' => 'required|string|max:45',
        ]);

        $usuario = New Usuario($request->all());
        $usuario->save();

        return response()->json($usuario, 201);
    }
}
