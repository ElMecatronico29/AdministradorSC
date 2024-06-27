<?php

namespace App\Http\Controllers;
use App\Models\Proyecto;
use App\Models\Profesore;
use App\Models\Usuario;
use App\Models\Estudiante;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    public function crearProyecto(Request $request){
        
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'profesor_nombre' => 'required|string|max:255',
            'area_aplicacion' => 'required|string|max:255',
            'estudiantes' => 'required|array',
            'estudiantes.*.usuario_id' => 'required|integer|exists:usuarios,id',
        ]);
        
        // Buscar al profesor por nombre
        $usuarioProfesor = Usuario::where('nombre', $data['profesor_nombre'])->first();
        
        if (!$usuarioProfesor) {
            return response()->json(['message' => 'Usuario Profesor no encontrado.'], 404);
        }
        $profesor = Profesore::where('usuario_id', $usuarioProfesor->id)->first();
        if (!$profesor) {
            return response()->json(['message' => 'Profesor no encontrado.'], 404);
        }
        DB::transaction(function () use ($data, $profesor) {
            // Crear el proyecto
            $proyecto = Proyecto::create([
                'titulo' => $data['titulo'],
                'descripcion' => $data['descripcion'] ?? null,
                'profesor_id' => $profesor->id,
                'area_aplicacion' => $data['area_aplicacion'],
                'estado' => 'Aceptado',
            ]);

            // Crear los usuarios y estudiantes
            foreach ($data['estudiantes'] as $estudianteData) {
                
                // Crear el estudiante y asociarlo al proyecto y al usuario
                $estudiante = Estudiante::where('usuario_id', $estudianteData['usuario_id'])->first();
                if($estudiante){
                    $estudiante->update([
                        'proyecto_id' => $proyecto->id,
                    ]);
                }
            }
        });

        return response()->json(['message' => 'Proyecto, usuarios y estudiantes creados exitosamente.'], 201);
    }
    public function listarProyectos()
    {
        $proyectos = Proyecto::with(['estudiantes', 'profesore'])->get();

        $result = $proyectos->map(function ($proyecto) {
            $integrantes = $proyecto->estudiantes->map(function ($estudiante) {
                return $estudiante->usuario->nombre;
            })->toArray();
            return [
                'nombre_del_proyecto' => $proyecto->titulo,
                'integrantes' => $integrantes,
                'profesorTutor' => $proyecto->profesore ? $proyecto->profesore->usuario->nombre : null,
            ];
        });

        return response()->json($result);
    }
}
