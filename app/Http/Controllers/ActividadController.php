<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Http\Requests\StoreActividadRequest;
use App\Http\Requests\UpdateActividadRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ActividadController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Actividad::withCount('alumnos');
            
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where('nombre', 'LIKE', "%{$search}%")
                    ->orWhere('descripcion', 'LIKE', "%{$search}%")
                    ->orWhere('dia_semana', 'LIKE', "%{$search}%");
            }
            
            $actividades = $query->latest()->get();
            
            return view('actividades.index', compact('actividades'));
            
        } catch (\Exception $e) {
            return redirect()->route('dashboard')
                ->with('error', 'Error al cargar las actividades: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('actividades.create');
    }

    public function store(StoreActividadRequest $request)
    {
        try {
            Actividad::create($request->validated());

            return redirect()->route('actividades.index')
                ->with('success', 'Actividad creada correctamente.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear la actividad: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $actividad = Actividad::withCount('alumnos')->with('alumnos')->findOrFail($id);
            return view('actividades.show', compact('actividad'));
            
        } catch (ModelNotFoundException $e) {
            return redirect()->route('actividades.index')
                ->with('error', 'Actividad no encontrada.');
        } catch (\Exception $e) {
            return redirect()->route('actividades.index')
                ->with('error', 'Error al cargar la actividad: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $actividad = Actividad::findOrFail($id);
            
            // Debug: log para verificar los datos (opcional)
            \Log::info('Editando actividad:', [
                'id' => $actividad->id,
                'hora_inicio' => $actividad->hora_inicio,
                'hora_inicio_formateada' => $actividad->hora_inicio_formateada ?? 'No disponible',
                'hora_finalizacion' => $actividad->hora_finalizacion,
                'hora_finalizacion_formateada' => $actividad->hora_finalizacion_formateada ?? 'No disponible',
            ]);
            
            return view('actividades.edit', compact('actividad'));
            
        } catch (ModelNotFoundException $e) {
            return redirect()->route('actividades.index')
                ->with('error', 'Actividad no encontrada.');
        } catch (\Exception $e) {
            return redirect()->route('actividades.index')
                ->with('error', 'Error al cargar la actividad para editar: ' . $e->getMessage());
        }
    }

    public function update(UpdateActividadRequest $request, $id)
    {
        try {
            $actividad = Actividad::findOrFail($id);
            $actividad->update($request->validated());

            return redirect()->route('actividades.index')
                ->with('success', 'Actividad actualizada correctamente.');
                
        } catch (ModelNotFoundException $e) {
            return redirect()->route('actividades.index')
                ->with('error', 'Actividad no encontrada.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar la actividad: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $actividad = Actividad::withCount('alumnos')->findOrFail($id);
            
            if ($actividad->alumnos_count > 0) {
                return redirect()->route('actividades.index')
                    ->with('error', 'No se puede eliminar la actividad porque tiene alumnos inscritos.');
            }

            $actividad->delete();

            return redirect()->route('actividades.index')
                ->with('success', 'Actividad eliminada correctamente.');
                
        } catch (ModelNotFoundException $e) {
            return redirect()->route('actividades.index')
                ->with('error', 'Actividad no encontrada.');
        } catch (\Exception $e) {
            return redirect()->route('actividades.index')
                ->with('error', 'Error al eliminar la actividad: ' . $e->getMessage());
        }
    }

    public function showAlumnos($id)
    {
        try {
            $actividad = Actividad::with('alumnos')->findOrFail($id);
            return view('actividades.lista-alumnos', compact('actividad'));
            
        } catch (ModelNotFoundException $e) {
            return redirect()->route('actividades.index')
                ->with('error', 'Actividad no encontrada.');
        } catch (\Exception $e) {
            return redirect()->route('actividades.index')
                ->with('error', 'Error al cargar los alumnos de la actividad: ' . $e->getMessage());
        }
    }
}