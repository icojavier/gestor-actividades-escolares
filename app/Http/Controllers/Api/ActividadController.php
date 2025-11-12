<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Actividad;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $actividades = Actividad::all();
            
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $actividad = Actividad::find($id);
            
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after:fecha_inicio',
                'precio' => 'required|numeric|min:0',
            ]);

            $actividad = Actividad::create($validated);

            return response()->json([
                'success' => true,
                'data' => $actividad,
                'message' => 'Actividad creada correctamente'
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la actividad: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $actividad = Actividad::find($id);
            
            if (!$actividad) {
                return response()->json([
                    'success' => false,
                    'message' => 'Actividad no encontrada'
                ], 404);
            }

            $validated = $request->validate([
                'nombre' => 'sometimes|string|max:255',
                'descripcion' => 'nullable|string',
                'fecha_inicio' => 'sometimes|date',
                'fecha_fin' => 'sometimes|date|after:fecha_inicio',
                'precio' => 'sometimes|numeric|min:0',
            ]);

            $actividad->update($validated);

            return response()->json([
                'success' => true,
                'data' => $actividad,
                'message' => 'Actividad actualizada correctamente'
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la actividad: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $actividad = Actividad::find($id);
            
            if (!$actividad) {
                return response()->json([
                    'success' => false,
                    'message' => 'Actividad no encontrada'
                ], 404);
            }

            $actividad->delete();

            return response()->json([
                'success' => true,
                'message' => 'Actividad eliminada correctamente'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la actividad: ' . $e->getMessage()
            ], 500);
        }
    }
}