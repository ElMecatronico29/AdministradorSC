<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\UsuarioController;


Route::get('/proyectos', [ProyectoController::class, 'listarProyectos']);
Route::get('/proyecto/{id}',[AdminController::class, 'progresoProyecto']);
Route::get('/profesores', [ProfesorController::class, 'listarProfesores']);
Route::get('/estudiantes', [EstudianteController::class, 'listarEstudiantes']);
Route::get('/solicitudes', [SolicitudController::class, 'listarSolicitudes']);
Route::put('/solicitudes/{id}/aceptar', [SolicitudController::class, 'aceptarSolicitud']);
Route::delete('/solicitudes/{id}/eliminar', [SolicitudController::class, 'eliminarSolicitud']);

Route::post('/crear_proyectos', [ProyectoController::class, 'crearProyecto']);
//Route::post('/proyecto/{id}',[AdminController::class, 'progresoProyecto']);
Route::post('/crear_profesores', [ProfesorController::class, 'crear']);
Route::post('/crear_solicitud', [SolicitudController::class, 'crearSolicitud']);
Route::post('/crear_usuario', [UsuarioController::class, 'crear']);
Route::post('/crear_estudiante', [EstudianteController::class, 'crear']);