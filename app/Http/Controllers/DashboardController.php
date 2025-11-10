<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Alumno;
use App\Models\Inscripcion;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalActividades = Actividad::count();
        $totalAlumnos = Alumno::count();
        $totalInscripciones = Inscripcion::count();

        $actividadesRecientes = Actividad::withCount('alumnos')
            ->latest()
            ->take(5)
            ->get();

        $alumnosRecientes = Alumno::withCount('actividades')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalActividades',
            'totalAlumnos',
            'totalInscripciones',
            'actividadesRecientes',
            'alumnosRecientes'
        ));
    }

    // Método para API de estadísticas (si lo necesitas)
    public function apiEstadisticas()
    {
        $totalActividades = Actividad::count();
        $totalAlumnos = Alumno::count();
        $totalInscripciones = Inscripcion::count();

        return response()->json([
            'total_actividades' => $totalActividades,
            'total_alumnos' => $totalAlumnos,
            'total_inscripciones' => $totalInscripciones,
            'actividad_popular' => Actividad::withCount('alumnos')
                ->orderBy('alumnos_count', 'desc')
                ->first()?->nombre ?? 'No hay datos',
            'alumno_activo' => Alumno::withCount('actividades')
                ->orderBy('actividades_count', 'desc')
                ->first()?->nombre_completo ?? 'No hay datos'
        ]);
    }

    // Método para API de status
    public function apiStatus()
    {
        return response()->json([
            'status' => 'OK',
            'message' => 'Sistema funcionando correctamente',
            'timestamp' => now()->toDateTimeString()
        ]);
    }
}
