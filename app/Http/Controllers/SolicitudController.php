<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitude;
use App\Models\Proyecto;
use App\Models\Estudiante;
use Illuminate\Support\Facades\DB;


class SolicitudController extends Controller
{
    public function crearSolicitud(Request $request){

        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'tutor_solicitado' => 'string',
            'areaAplicacion' => 'required|string',
            'estudiantes' => 'required|array',
            'estudiantes.*.usuario_id' => 'required|integer|exists:usuarios,id',
        ]);

        DB::transaction(function () use ($data) {
            // Crear el solicitud
            $solicitud = Solicitude::create([
                'titulo' => $data['titulo'],
                'descripcion' => $data['descripcion'] ?? null,
                'tutor_solicitado' => $data['tutor_solicitado'] ?? null,
                'areaAplicacion' => $data['areaAplicacion'] ,
            ]);

            foreach ($data['estudiantes'] as $estudianteData) {
                
                // Crear el estudiante y asociarlo al solicitud y al usuario
                $estudiante = Estudiante::where('usuario_id', $estudianteData['usuario_id'])->first();
                if($estudiante){
                    $estudiante->update([
                        'solicitud_id' => $solicitud->id,
                    ]);
                }
            }
        });

        return response()->json(['message' => 'solicitud creada exitosamente.'], 201);

    }
    public function listarSolicitudes()
    {
        $solicitudes = Solicitude::select('id','titulo', 'descripcion','areaAplicacion', 'tutor_solicitado')->get();

        return response()->json($solicitudes);
    }
    public function aceptarSolicitud($id)
    {
        // Obtener la solicitud por su ID
        $solicitud = Solicitude::findOrFail($id);
        
        $estudiantes = Estudiante::where('solicitud_id', $id)->get();

        $estudianteIds = $estudiantes->pluck('usuario_id')->toArray();
        $datosProyecto = [
            'titulo' => $solicitud->titulo,
            'descripcion' => $solicitud->descripcion,
            'profesor_nombre' => $solicitud->tutor_solicitado,
            'area_aplicacion' => $solicitud->areaAplicacion,
            'estudiantes' => array_map(function ($usuarioId) {
                return ['usuario_id' => $usuarioId];
            }, $estudianteIds),
        ];
        // return response()->json($datosProyecto);
        $request = new Request($datosProyecto);
        $proyectoController = app(ProyectoController::class);
        $solicitud->delete();
        
        return $proyectoController->crearProyecto($request);
    }

    public function eliminarSolicitud($id)
    {
        // Buscar la solicitud por su ID
        $solicitud = Solicitude::findOrFail($id);

        // Eliminar la solicitud
        $solicitud->delete();

        return response()->json(['message' => 'Solicitud eliminada correctamente']);
    }
    
}
