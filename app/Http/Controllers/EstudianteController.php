<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Usuario;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function crear(Request $request){
        
        $request->validate([
            'usuario_id' => 'required|string|max:255',
            'carrera' => 'required|string|max:255',
        ]);

        // Buscar al profesor por nombre
        $usuario = Usuario::where('id', $request->usuario_id)->first();

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }
        $estudiante = new Estudiante($request->all());
        $estudiante->save();

        return response()->json($estudiante, 201);    

    }
    public function listarEstudiantes()
    {
        $estudiantes = Estudiante::with(['proyecto', 'usuario'])->get();

        $result = $estudiantes->map(function($estudiante) {
            return [
                'nombre' => $estudiante->usuario->nombre,
                'cedula' => $estudiante->usuario->cedula,
                'carrera' => $estudiante->carrera,
                'proyecto_asignado' => $estudiante->proyecto ? $estudiante->proyecto->titulo : 'Ninguno',
                'area_aplicacion' => $estudiante->proyecto ? $estudiante->proyecto->area_aplicacion : 'Ninguno',
            ];
        });

        return response()->json($result);
    }
}