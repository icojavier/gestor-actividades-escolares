<?php

use App\Http\Controllers\Api\ActividadController;
use App\Http\Controllers\Api\AlumnoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Ruta de estado de la API
Route::get('/status', function () {
    return response()->json([
        'status' => 'OK',
        'service' => 'Gestor de Actividades Escolares API',
        'version' => '1.0.0',
        'timestamp' => now()->toISOString(),
        'environment' => app()->environment()
    ]);
});

// Rutas públicas de la API
Route::prefix('v1')->group(function () {
    
    // Actividades - Solo lectura
    Route::get('/actividades', [ActividadController::class, 'index']);
    Route::get('/actividades/{id}', [ActividadController::class, 'show']);
    
    // Alumnos - Solo lectura (opcional)
    Route::get('/alumnos', function () {
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

    Route::get('/alumnos/{id}', function ($id) {
        try {
            $alumno = App\Models\Alumno::withCount('actividades')->with('actividades')->find($id);
            
            if (!$alumno) {
                return response()->json([
                    'success' => false,
                    'message' => 'Alumno no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $alumno,
                'message' => 'Alumno obtenido correctamente'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el alumno: ' . $e->getMessage()
            ], 500);
        }
    });

    // Estadísticas generales
    Route::get('/estadisticas', function () {
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
});

// Ruta por defecto para API no encontrada
Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'Endpoint de API no encontrado. Consulte la documentación.',
        'available_endpoints' => [
            'GET /api/status',
            'GET /api/v1/actividades',
            'GET /api/v1/actividades/{id}',
            'GET /api/v1/alumnos',
            'GET /api/v1/alumnos/{id}',
            'GET /api/v1/estadisticas'
        ]
    ], 404);
});