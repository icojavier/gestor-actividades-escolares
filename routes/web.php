<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\PdfExportController;
use Illuminate\Support\Facades\Route;

// Ruta del Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Rutas para Actividades (Resource)
Route::resource('actividades', ActividadController::class);

// Ruta adicional para ver alumnos de una actividad
Route::get('actividades/{id}/alumnos', [ActividadController::class, 'showAlumnos'])->name('actividades.alumnos');

// Rutas para Alumnos (Resource)
Route::resource('alumnos', AlumnoController::class);

// Rutas para Inscripciones - AGREGAR index y show
Route::resource('inscripciones', InscripcionController::class)->only(['index', 'create', 'store', 'show', 'destroy']);

// Rutas para Exportación PDF
Route::get('/export/actividades', [PdfExportController::class, 'exportAllActividades'])->name('export.actividades.all');
Route::get('/export/actividad/{id}/alumnos', [PdfExportController::class, 'exportActividadAlumnos'])->name('export.actividad.alumnos');
Route::get('/export/alumnos', [PdfExportController::class, 'exportAllAlumnos'])->name('export.alumnos.all');
Route::get('/export/alumno/{id}/actividades', [PdfExportController::class, 'exportAlumnoActividades'])->name('export.alumno.actividades');

// Rutas API Web (para consumo desde frontend u otras aplicaciones)
Route::get('/api-web/actividades', [ActividadController::class, 'apiIndex'])->name('api.web.actividades');
Route::get('/api-web/alumnos', [AlumnoController::class, 'apiIndex'])->name('api.web.alumnos');
Route::get('/api-web/estadisticas', [DashboardController::class, 'apiEstadisticas'])->name('api.web.estadisticas');
Route::get('/api-web/status', [DashboardController::class, 'apiStatus'])->name('api.web.status');

// Ruta principal redirige al dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});
