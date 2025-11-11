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

// 🔴 PROBLEMA ORIGINAL - Esto no está funcionando correctamente
// Route::resource('inscripciones', InscripcionController::class)->only(['index', 'create', 'store', 'show', 'destroy']);

// ✅ SOLUCIÓN 1: Usar rutas individuales explícitas (RECOMENDADO)
Route::get('/inscripciones', [InscripcionController::class, 'index'])->name('inscripciones.index');
Route::get('/inscripciones/create', [InscripcionController::class, 'create'])->name('inscripciones.create');
Route::post('/inscripciones', [InscripcionController::class, 'store'])->name('inscripciones.store');
Route::get('/inscripciones/{id}', [InscripcionController::class, 'show'])->name('inscripciones.show');
Route::delete('/inscripciones/{id}', [InscripcionController::class, 'destroy'])->name('inscripciones.destroy');

// ✅ O SOLUCIÓN 2: Usar resource con except (alternativa)
// Route::resource('inscripciones', InscripcionController::class)->except(['edit', 'update']);

// NUEVA RUTA: Exportar inscripciones a PDF
Route::get('/export/inscripciones', [InscripcionController::class, 'exportPdf'])->name('export.inscripciones');

// Rutas para Exportación PDF existentes
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
