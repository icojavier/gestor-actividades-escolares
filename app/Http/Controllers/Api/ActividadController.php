<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Actividad;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    public function index()
    {
        try {
            $actividades = Actividad::withCount('alumnos')->get();
            
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
    }

    public function show($id)
    {
        try {
            $actividad = Actividad::withCount('alumnos')->with('alumnos')->find($id);
            
            if (!$actividad) {
                return response()->json([
                    'success' => false,
                    'message' => 'Actividad no encontrada'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $actividad,
                'message' => 'Actividad obtenida correctamente'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la actividad: ' . $e->getMessage()
            ], 500);
        }
    }

    // Métodos restantes (solo lectura)
    public function store(Request $request)
    {
        return response()->json([
            'success' => false,
            'message' => 'Operación no permitida en la API pública'
        ], 403);
    }

    public function update(Request $request, $id)
    {
        return response()->json([
            'success' => false,
            'message' => 'Operación no permitida en la API pública'
        ], 403);
    }

    public function destroy($id)
    {
        return response()->json([
            'success' => false,
            'message' => 'Operación no permitida en la API pública'
        ], 403);
    }
}