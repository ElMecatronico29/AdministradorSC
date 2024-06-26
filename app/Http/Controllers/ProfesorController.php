<?php

namespace App\Http\Controllers;

use App\Models\Profesore;
use App\Models\Usuario;
use Illuminate\Http\Request;

class ProfesorController extends Controller
{
    public function crear(Request $request){

        $request->validate([
            'usuario_id' => 'required|string|max:255',
            'departamento' => 'required|string|max:255',
        ]);

        // Buscar al profesor por nombre
        $usuario = Usuario::where('id', $request->usuario_id)->first();

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }
        $profesor = new Profesore($request->all());
        $profesor->save();

        return response()->json($profesor, 201);    

    }
    public function listarProfesores()
    {
        $profesores = Profesore::with(['proyectos', 'usuario'])->get();
        
        $result = $profesores->map(function($profesor) {
            return [
                'nombre' => $profesor->usuario->nombre,
                'cedula' => $profesor->usuario->cedula,
                'departamento' => $profesor->departamento,
                'proyectos_asignados' => $profesor->proyectos->map(function($proyecto) {
                    return $proyecto->titulo;
                })->toArray(),
                'proyecto_actual_activo' => $profesor->proyectos->filter(function ($proyecto) {
                    return $proyecto->estado !== 'finalizado';
                })->first() ? $profesor->proyectos->filter(function ($proyecto) {
                    return $proyecto->estado !== 'finalizado';
                })->first()->titulo : 'Ninguno',
                ];
        });

        return response()->json($result);
    }
}
