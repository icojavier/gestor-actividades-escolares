<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\InscripcionController;
use App\Models\Actividad;
use App\Models\Alumno;
use App\Models\Inscripcion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Ruta para la página principal del gestor
Route::get('/dashboard', function () {
    $totalActividades = Actividad::count();
    $totalAlumnos = Alumno::count();
    $totalInscripciones = Inscripcion::count();
    $actividadesRecientes = Actividad::latest()->take(5)->get();
    $alumnosRecientes = Alumno::latest()->take(5)->get();

    return view('dashboard', compact(
        'totalActividades',
        'totalAlumnos', 
        'totalInscripciones',
        'actividadesRecientes',
        'alumnosRecientes'
    ));
})->name('dashboard');

// Rutas RESTful para los recursos
Route::resource('actividades', ActividadController::class);
Route::resource('alumnos', AlumnoController::class);
Route::resource('inscripciones', InscripcionController::class)->only(['create', 'store', 'destroy']);

// Rutas para exportación PDF
Route::get('/export/actividad/{id}/alumnos', function($id) {
    $actividad = Actividad::with('alumnos')->findOrFail($id);
    
    $pdf = Pdf::loadView('pdf.actividad-alumnos', compact('actividad'));
    
    return $pdf->download("alumnos-{$actividad->nombre}.pdf");
})->name('export.actividad.alumnos');

Route::get('/export/actividades', function() {
    $actividades = Actividad::withCount('alumnos')->get();
    
    $pdf = Pdf::loadView('pdf.all-actividades', compact('actividades'));
    
    return $pdf->download('todas-actividades.pdf');
})->name('export.actividades.all');

// Rutas web para probar la API - DEFINITIVAS
Route::get('/api-web/status', function () {
    return response()->json([
        'status' => 'OK',
        'service' => 'Gestor de Actividades Escolares API',
        'version' => '1.0.0',
        'timestamp' => now()->toISOString(),
        'environment' => app()->environment()
    ]);
});

Route::get('/api-web/actividades', function () {
    try {
        $actividades = App\Models\Actividad::withCount('alumnos')->get();
        
        return response()->json([
            'success' => true,
            'data' => $actividades,
            'message' => 'Lista de actividades obtenida correctamente',
            'count' => $actividades->count()
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al obtener las actividades: ' . $e->getMessage()
        ], 500);
    }
});

Route::get('/api-web/alumnos', function () {
    try {
        $alumnos = App\Models\Alumno::withCount('actividades')->get();
        
        return response()->json([
            'success' => true,
            'data' => $alumnos,
            'message' => 'Lista de alumnos obtenida correctamente',
            'count' => $alumnos->count()
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al obtener los alumnos: ' . $e->getMessage()
        ], 500);
    }
});

Route::get('/api-web/estadisticas', function () {
    try {
        $totalActividades = App\Models\Actividad::count();
        $totalAlumnos = App\Models\Alumno::count();
        $totalInscripciones = App\Models\Inscripcion::count();
        $actividadMasPopular = App\Models\Actividad::withCount('alumnos')
            ->orderBy('alumnos_count', 'desc')
            ->first();

        return response()->json([
            'success' => true,
            'data' => [
                'total_actividades' => $totalActividades,
                'total_alumnos' => $totalAlumnos,
                'total_inscripciones' => $totalInscripciones,
                'actividad_mas_popular' => $actividadMasPopular
            ],
            'message' => 'Estadísticas obtenidas correctamente'
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al obtener las estadísticas: ' . $e->getMessage()
        ], 500);
    }
});

// Ruta para ver la lista de alumnos por actividad
Route::get('/actividades/{id}/alumnos', [ActividadController::class, 'showAlumnos'])
    ->name('actividades.alumnos');

// Rutas para exportación PDF de alumnos
Route::get('/export/alumnos', function() {
    // Corregir la consulta especificando la tabla de actividades
    $alumnos = App\Models\Alumno::withCount('actividades')
                ->with(['actividades' => function($query) {
                    $query->select(
                        'actividades.id', 
                        'actividades.nombre', 
                        'actividades.dia_semana', 
                        'actividades.hora_inicio', 
                        'actividades.hora_finalizacion'
                    );
                }])
                ->get();
    
    $pdf = Pdf::loadView('pdf.all-alumnos', compact('alumnos'));
    
    return $pdf->download('todos-alumnos.pdf');
})->name('export.alumnos.all');

Route::get('/export/alumno/{id}/actividades', function($id) {
    $alumno = App\Models\Alumno::with(['actividades' => function($query) {
        $query->select(
            'actividades.id', 
            'actividades.nombre', 
            'actividades.descripcion',
            'actividades.dia_semana', 
            'actividades.hora_inicio', 
            'actividades.hora_finalizacion'
        );
    }])->findOrFail($id);
    
    $pdf = Pdf::loadView('pdf.alumno-actividades', compact('alumno'));
    
    return $pdf->download("actividades-{$alumno->nombre_completo}.pdf");
})->name('export.alumno.actividades');